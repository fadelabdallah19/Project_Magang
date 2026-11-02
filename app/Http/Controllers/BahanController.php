<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BahanController extends Controller
{
    public function index(): View
    {
        $bahan = Bahan::orderBy('kode')->get();

        return view('bahan.index', compact('bahan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:20', Rule::unique('bahan', 'kode')],
            'nama' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'string', 'max:50'],
            'stok' => ['required', 'integer', 'min:0'],
            'satuan' => ['required', 'string', 'max:20'],
        ]);

        Bahan::create($validated);

        return redirect()
        ->route('bahan.index')
        ->with('success', "Bahan \"{$validated['nama']}\" berhasil ditambahkan.");
    }

    public function update(Request $request, string $kode): RedirectResponse
    {
        $bahan = Bahan::where('kode', $kode)->firstOfFail();

        $validated = $request->validate([
             'kode' => ['required', 'string', 'max:20', Rule::unique('bahan', 'kode')->ignore($bahan->id)],
            'nama' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'string', 'max:50'],
            'stok' => ['required', 'integer', 'min:0'],
            'satuan' => ['required', 'string', 'max:20'],
        ]);

        $bahan->update($validated);

        return redirect()
        ->route('bahan.index')
        ->with('success', "Bahan \"{$bahan->nama}\" berhasil diperbarui.");
    }
}