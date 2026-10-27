<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarangMasukController extends Controller
{
    public function index(): View
    {
        $barangMasuk = $this->data();
        $bahan = $this->bahan();

        return view('barang-masuk.index', compact('barangMasuk', 'bahan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'kode' => ['required', 'string', 'max:20'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'satuan' => ['required', 'string', 'max:20'],
            'supplier' => ['request', 'string', 'max:100']
        ]);

        // data dummy
        return redirect()
        ->route('barang-masuk.index')
        ->with('success', "Barang masuk \"{$validated['kode']}\" sebanyak {$validated['jumlah']} {$validated['satuan']} berhasil dicatat.");

        // Barang Masuk
        // $validated = $request->validate([
        //     'tanggal' => ['requred', 'date'],
        //     'kode' => ['required', 'string', 'max:20'],
        //     'jumlah' => ['required', 'integer', 'min:1'],
        //     'satuan' => ['required', 'string', 'max:20'],
        //     'supplier' => ['nulable', 'string', 'max:100'],
        // ]);

        // // data dummy
        return redirect()
        ->route('barang-masuk.index')
        ->with('success', 'Penerimaan barang berhasil dicatat.');
    }

    

    private function data(): array
    {
        // data dummy
        return [
            ['no' => 'BM-2026-001', 'tanggal' => '24 Okt 2026', 'kode' => 'MBG-001', 'nama' => 'Beras',             'jumlah' => 50, 'satuan' => 'Kg',    'supplier' => 'CV Sumber Pangan',   'status' => 'Diterima'],
            ['no' => 'BM-2026-002', 'tanggal' => '24 Okt 2026', 'kode' => 'MBG-002', 'nama' => 'Daging Ayam Fresh', 'jumlah' => 30, 'satuan' => 'Kg',    'supplier' => 'PT Ayam Segar Jaya', 'status' => 'Diterima'],
            ['no' => 'BM-2026-003', 'tanggal' => '23 Okt 2026', 'kode' => 'MBG-003', 'nama' => 'Kentang',           'jumlah' => 40, 'satuan' => 'Kg',    'supplier' => 'CV Tani Makmur',     'status' => 'Diterima'],
            ['no' => 'BM-2026-004', 'tanggal' => '22 Okt 2026', 'kode' => 'MBG-005', 'nama' => 'Kecap Manis',       'jumlah' => 20, 'satuan' => 'Liter', 'supplier' => 'UD Bumbu Nusantara', 'status' => 'Diterima'],
            ['no' => 'BM-2026-005', 'tanggal' => '22 Okt 2026', 'kode' => 'MBG-004', 'nama' => 'Tempe',             'jumlah' => 25, 'satuan' => 'Kg',    'supplier' => 'Koperasi Tempe Sehat', 'status' => 'Diterima'],
        ];

        // Barang Masuk
        // return [
        // ['no' => 'BM-2026-001', 'tanggal' => '24 Okt 2026', 'waktu' => '10:15 WIB', 'kode' => 'MBG-001', 'nama' => 'Beras',             'jumlah' => 50, 'satuan' => 'Kg',    'supplier' => 'Pengiriman Gudang Utama', 'status' => 'Diterima'],
        // ['no' => 'BM-2026-002', 'tanggal' => '24 Okt 2026', 'waktu' => '09:40 WIB', 'kode' => 'MBG-002', 'nama' => 'Daging Ayam Fresh', 'jumlah' => 30, 'satuan' => 'Kg',    'supplier' => 'PT Ayam Segar Jaya',      'status' => 'Diterima'],
        // ['no' => 'BM-2026-003', 'tanggal' => '23 Okt 2026', 'waktu' => '13:20 WIB', 'kode' => 'MBG-003', 'nama' => 'Kentang',           'jumlah' => 40, 'satuan' => 'Kg',    'supplier' => 'CV Tani Makmur',          'status' => 'Diterima'],
        // ['no' => 'BM-2026-004', 'tanggal' => '22 Okt 2026', 'waktu' => '11:05 WIB', 'kode' => 'MBG-005', 'nama' => 'Kecap Manis',       'jumlah' => 20, 'satuan' => 'Liter', 'supplier' => 'UD Bumbu Nusantara',      'status' => 'Diterima'],
        // ['no' => 'BM-2026-005', 'tanggal' => '22 Okt 2026', 'waktu' => '08:30 WIB', 'kode' => 'MBG-004', 'nama' => 'Tempe',             'jumlah' => 25, 'satuan' => 'Kg',    'supplier' => 'Koperasi Tempe Sehat',    'status' => 'Diterima'],
        // ];
    }

    private function bahan(): array
    {
        // Data Dummy (untuk dropdown)
        return [
            ['kode' => 'MBG-001', 'nama' => 'Beras',             'satuan' => 'Kg'],
            ['kode' => 'MBG-002', 'nama' => 'Daging Ayam Fresh', 'satuan' => 'Kg'],
            ['kode' => 'MBG-003', 'nama' => 'Kentang',           'satuan' => 'Kg'],
            ['kode' => 'MBG-004', 'nama' => 'Tempe',             'satuan' => 'Kg'],
            ['kode' => 'MBG-005', 'nama' => 'Kecap Manis',       'satuan' => 'Liter'],
        ];
    } 
}