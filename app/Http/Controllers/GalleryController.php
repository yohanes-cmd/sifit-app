<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Admin: List all gallery items.
     */
    public function index()
    {
        $galleries = Gallery::with('user')->latest()->paginate(15);

        return view('galleries.index', compact('galleries'));
    }

    /**
     * Admin: Show create gallery form.
     */
    public function create()
    {
        return view('galleries.create');
    }

    /**
     * Admin: Store new gallery item.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:photo,video',
            'description' => 'nullable|string',
            'media_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,mp4,mov,avi|max:20480',
            'youtube_url' => 'nullable|url|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $filePath = null;
        if ($request->hasFile('media_file')) {
            $filePath = $request->file('media_file')->store('galleries', 'public');
        }

        Gallery::create([
            'user_id' => Auth::id() ?? 1,
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'file_path' => $filePath,
            'youtube_url' => $request->youtube_url,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('galleries.index')->with('success', 'Dokumentasi galeri berhasil ditambahkan!');
    }

    /**
     * Admin: Show edit gallery form.
     */
    public function edit(Gallery $gallery)
    {
        return view('galleries.edit', compact('gallery'));
    }

    /**
     * Admin: Update gallery item.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:photo,video',
            'description' => 'nullable|string',
            'media_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,mp4,mov,avi|max:20480',
            'youtube_url' => 'nullable|url|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $filePath = $gallery->file_path;
        if ($request->hasFile('media_file')) {
            if ($gallery->file_path && Storage::disk('public')->exists($gallery->file_path)) {
                Storage::disk('public')->delete($gallery->file_path);
            }
            $filePath = $request->file('media_file')->store('galleries', 'public');
        }

        $gallery->update([
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'file_path' => $filePath,
            'youtube_url' => $request->youtube_url,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('galleries.index')->with('success', 'Dokumentasi galeri berhasil diperbarui!');
    }

    /**
     * Admin: Delete gallery item.
     */
    public function destroy(Gallery $gallery)
    {
        if ($gallery->file_path && Storage::disk('public')->exists($gallery->file_path)) {
            Storage::disk('public')->delete($gallery->file_path);
        }

        $gallery->delete();

        return redirect()->route('galleries.index')->with('success', 'Dokumentasi galeri berhasil dihapus!');
    }

    /**
     * Frontend: Public gallery index page.
     */
    public function frontendIndex(Request $request)
    {
        $type = $request->get('type');

        $query = Gallery::active();

        if (in_array($type, ['photo', 'video'])) {
            $query->where('type', $type);
        }

        $galleries = $query->paginate(12)->withQueryString();

        $totalPhoto = Gallery::where('type', 'photo')->where('is_active', true)->count();
        $totalVideo = Gallery::where('type', 'video')->where('is_active', true)->count();
        $totalAll = $totalPhoto + $totalVideo;

        return view('frontend.galeri.index', compact('galleries', 'type', 'totalPhoto', 'totalVideo', 'totalAll'));
    }

    /**
     * Frontend: Public gallery detail page.
     */
    public function frontendShow(Gallery $gallery)
    {
        abort_unless($gallery->is_active, 404);

        $gallery->load('user');

        $relatedGalleries = Gallery::active()
            ->where('id', '!=', $gallery->id)
            ->where('type', $gallery->type)
            ->latest()
            ->take(3)
            ->get();

        if ($relatedGalleries->isEmpty()) {
            $relatedGalleries = Gallery::active()
                ->where('id', '!=', $gallery->id)
                ->latest()
                ->take(3)
                ->get();
        }

        return view('frontend.galeri.show', compact('gallery', 'relatedGalleries'));
    }
}
