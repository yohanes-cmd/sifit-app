<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = News::with(['category', 'user'])->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('category_name', function ($row) {
                    return $row->category ? $row->category->name : '-';
                })
                ->addColumn('author_name', function ($row) {
                    return $row->user ? $row->user->name : 'Admin';
                })
                ->addColumn('status_badge', function ($row) {
                    if ($row->status == 'publish') {
                        return '<span class="badge bg-success">Publish</span>';
                    }
                    return '<span class="badge bg-warning text-dark">Draft</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<button data-id="' . $row->id . '" class="btn btn-warning btn-sm editNews text-white">Ubah</button> ';
                    $btn .= '<button data-id="' . $row->id . '" class="btn btn-danger btn-sm deleteNews">Hapus</button>';
                    return $btn;
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }

        return view('news.index');
    }

    public function create()
    {
        $categories = Category::where('type', 'news')->orWhereNull('type')->get();
        return view('news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'status' => 'required|in:draft,publish',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:10240', // Validasi PDF maks 10MB
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news-images', 'public');
        }

        $pdfPath = null;
        if ($request->hasFile('pdf_file')) {
            $pdfPath = $request->file('pdf_file')->store('news-pdfs', 'public');
        }

        News::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'category_id' => $request->category_id,
            'user_id' => Auth::id() ?? 1,
            'content' => $request->content,
            'status' => $request->status,
            'image' => $imagePath,
            'pdf_file' => $pdfPath, // Simpan path PDF ke database
            'published_at' => $request->status == 'publish' ? now() : null,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Berita berhasil diterbitkan!']);
    }

    public function edit($id)
    {
        $news = News::find($id);
        return response()->json($news);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'status' => 'required|in:draft,publish',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:10240', // Validasi PDF maks 10MB
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        $news = News::find($id);

        // Penanganan upload ulang Gambar
        $imagePath = $news->image;
        if ($request->hasFile('image')) {
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }
            $imagePath = $request->file('image')->store('news-images', 'public');
        }

        // Penanganan upload ulang PDF
        $pdfPath = $news->pdf_file;
        if ($request->hasFile('pdf_file')) {
            if ($news->pdf_file && Storage::disk('public')->exists($news->pdf_file)) {
                Storage::disk('public')->delete($news->pdf_file);
            }
            $pdfPath = $request->file('pdf_file')->store('news-pdfs', 'public');
        }

        $news->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'category_id' => $request->category_id,
            'content' => $request->content,
            'status' => $request->status,
            'image' => $imagePath,
            'pdf_file' => $pdfPath, // Update data PDF
            'published_at' => $request->status == 'publish' && !$news->published_at ? now() : $news->published_at,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Berita berhasil diperbarui!']);
    }

    public function frontendIndex(Request $request)
    {
        $query = News::with(['category', 'user'])
            ->where('status', 'publish')
            ->latest('published_at');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $news = $query->paginate(6)->withQueryString();

        return view('frontend.berita.index', compact('news'));
    }

    public function frontendShow($slug)
    {
        $news = News::with(['category', 'user'])
            ->where('slug', $slug)
            ->where('status', 'publish')
            ->firstOrFail();

        $latestNews = News::with(['category', 'user'])
            ->where('status', 'publish')
            ->where('id', '!=', $news->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('frontend.berita.detail', compact('news', 'latestNews'));
    }


    public function destroy($id)
    {
        $news = News::find($id);

        // Hapus file gambar dari storage jika ada
        if ($news->image && Storage::disk('public')->exists($news->image)) {
            Storage::disk('public')->delete($news->image);
        }

        // Hapus file PDF dari storage jika ada
        if ($news->pdf_file && Storage::disk('public')->exists($news->pdf_file)) {
            Storage::disk('public')->delete($news->pdf_file);
        }

        $news->delete();

        return response()->json(['status' => 'success', 'message' => 'Berita berhasil dihapus!']);
    }
}
