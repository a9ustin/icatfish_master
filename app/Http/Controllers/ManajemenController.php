<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manajemen;

class ManajemenController extends Controller
{
    // Menampilkan semua data manajemen
    public function index()
    {
        $manajemen = Manajemen::all();
        return view('admin.manajemen.index', compact('manajemen'));
    }

    // Menampilkan form untuk menambahkan data manajemen
    public function create()
    {
        return view('admin.manajemen.create');
    }

    // Menyimpan data manajemen yang baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:pakan,olahan ikan,perlengkapan',
            'stock' => 'required|integer',
        ]);

        Manajemen::create($validatedData);

        return redirect()->route('admin.manajemen.index')->with('success', 'Data manajemen berhasil ditambahkan.');
    }

    // Menampilkan data manajemen yang akan diubah
    public function edit($id)
    {
        $manajemen = Manajemen::findOrFail($id);
        return view('admin.manajemen.edit', compact('manajemen'));
    }

    // Menyimpan perubahan pada data manajemen
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            // Definisikan validasi sesuai kebutuhan
        ]);

        Manajemen::whereId($id)->update($validatedData);

        return redirect()->route('admin.manajemen.index')->with('success', 'Data manajemen berhasil diperbarui.');
    }

    // Menghapus data manajemen
    public function destroy($id)
    {
        $manajemen = Manajemen::findOrFail($id);
        $manajemen->delete();

        return redirect()->route('admin.manajemen.index')->with('success', 'Data manajemen berhasil dihapus.');
    }
}