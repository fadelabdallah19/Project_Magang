<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BahanController extends Controller
{
    public function index(): View
    {
        $bahan = $this->data();

        return view('bahan.index', compact('bahan'));
    }

    public function edit(string $kode): View
    {
        $bahan = collect($this->data())->firstWhere('kode', $kode);

        abort_if($bahan === null, 404, 'Bahan pangan tidak ditemukan.');

        return view('bahan.edit', compact('bahan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
        'kode'     => ['required', 'string', 'max:20'],
        'nama'     => ['required', 'string', 'max:100'],
        'kategori' => ['required', 'string', 'max:50'],
        'stok'     => ['required', 'integer', 'min:0'],
        'satuan'   => ['required', 'string', 'max:20'],
        ]);

        // masih data dummy
        return redirect()
        ->route('bahan.index')
        ->with('success', "Bahan \"{$validated('nama')}\" berhasil ditambahkan."); 
    }
    
    public function update(Request $request, string $kode): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'string', 'max:50'],
            'stok' => ['required', 'integer', 'max:0'],
            'satuan' => ['required', 'string', 'max:20'],
        ]);

        // masih data dummy
        return redirect()
        ->route('bahan.index')
        ->with('success', "Bahan \"{$validated['nama']}\" berhasil diperbarui.");
    }

    private function data(): array
    {
        // Data Dummy
        return [
            ['kode' => 'MBG-001', 'nama' => 'Beras', 'kategori' => 'Sembako', 'stok' => 120, 'satuan' => 'Kg', 'status' => 'Aman'],
            ['kode' => 'MBG-002', 'nama' => 'Daging Ayam Fresh', 'kategori' => 'Protein', 'stok' => 50, 'satuan' => 'Kg', 'status' => 'Aman'],
            ['kode' => 'MBG-003', 'nama' => 'Kentang', 'kategori' => 'Karbohidrat', 'stok' => 15,  'satuan' => 'Kg', 'status' => 'Stok Rendah'],
            ['kode' => 'MBG-004', 'nama' => 'Tempe', 'kategori' => 'Protein', 'stok' => 8, 'satuan' => 'Kg', 'status' => 'Stok Rendah'],
            ['kode' => 'MBG-005', 'nama' => 'Kecap Manis', 'kategori' => 'Bumbu', 'stok' => 70, 'satuan' => 'Liter', 'status' => 'Aman'],
        ];

            //return view('bahan.index', compact('bahan'));
    }
}




