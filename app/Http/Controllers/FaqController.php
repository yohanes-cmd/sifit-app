<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('order', 'asc')->orderBy('id', 'desc')->get();

        return view('pengaturan.faq.index', compact('faqs'));
    }

    public function create()
    {
        return view('pengaturan.faq.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->has('is_active');

        Faq::create($validated);

        return redirect()->route('faq.index')->with('success', 'Pertanyaan FAQ berhasil ditambahkan!');
    }

    public function edit(Faq $faq)
    {
        return view('pengaturan.faq.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->has('is_active');

        $faq->update($validated);

        return redirect()->route('faq.index')->with('success', 'Pertanyaan FAQ berhasil diperbarui!');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('faq.index')->with('success', 'Pertanyaan FAQ berhasil dihapus!');
    }
}
