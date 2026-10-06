<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::latest()->get();

        return view('pengaturan.program.index', compact('programs'));
    }

    public function create()
    {
        return view('pengaturan.program.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:programs,kode',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Program::create($request->all());

        return redirect()->route('program.index')->with('success', 'Data program berhasil ditambahkan!');
    }

    public function show(Program $program)
    {
        return view('pengaturan.program.show', compact('program'));
    }

    public function edit(Program $program)
    {
        return view('pengaturan.program.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:programs,kode,'.$program->id,
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $program->update($request->all());

        return redirect()->route('program.index')->with('success', 'Data program berhasil diperbarui!');
    }

    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('program.index')->with('success', 'Data program berhasil dihapus!');
    }
}
