<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarangKeluarController extends Controller
{
    public function index(): View
    {
        $barangKeluar = $this->data();

        return view('barang-keluar.index', compact('barangKeluar'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'nama' => ['required', 'string', 'max:100'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'supplier' => ['nullable', 'string', 'max:100'],
        ]);

        return redirect()
        ->route('barang-keluar.index')
        ->with('success', "Pengeluaran \"{$validated['nama']}\" sebanyak {$validated['jumlah']} berhasil dicatat.");
    }

    private function data(): array
    {
        // data dummy
        return [
            ['waktu' => '10:15 WIB', 'nama' => 'Beras', 'jumlah' => 50, 'satuan' => 'Kg', 'supplier' => 'Pengiriman Gudang Utama'],
            ['waktu' => '09:40 WIB', 'nama' => 'Daging Ayam Fresh', 'jumlah' => 30, 'satuan' => 'Kg', 'supplier' => 'Distribusi Produksi'],
            ['waktu' => '13:20 WIB', 'nama' => 'Kentang', 'jumlah' => 40, 'satuan' => 'Kg', 'supplier' => 'Distribusi Produksi'],
            ['waktu' => '11:05 WIB', 'nama' => 'Kecap Manis', 'jumlah' => 20, 'satuan' => 'Liter', 'supplier' => 'Distribusi Dapur'],
            ['waktu' => '08:30 WIB', 'nama' => 'Tempe', 'jumlah' => 25, 'satuan' => 'Kg', 'supplier' => 'Distribusi Produksi'],
        ];
    }
}