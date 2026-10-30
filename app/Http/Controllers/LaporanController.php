<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index(): View
    {
        $laporan = $this->data();

        $ringkasan = [
            'jenis' => count($laporan),
            'masuk' => 128,
            'keluar' => 96,
            'status' => 'Aman'
        ];

        return view('laporan.index', compact('laporan', 'ringkasan'));
    }

    public function export(): StreamedResponse
    {
        $laporan = $this->data();

        return response()->streamDownload(function () use ($laporan) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Kode', 'Nama Bahan', 'Kategori', 'Stok Akhir', 'Satuan']);

            foreach ($laporan as $item) {
                fputcsv($handle, [
                    $item['kode'],
                    $item['nama'],
                    $item['kategori'],
                    $item['stok'],
                    $item['satuan'],
                ]);
            }
            fclose($handle);
        }, 'laporan-persediaan-' . now()->format('Y-m-d') . '.csv');
    }

    private function data(): array
    {
        return [
            ['kode' => 'MBG-001', 'kategori' => 'Sembako', 'nama' => 'Beras', 'satuan' => 'Kg', 'stok' => 120],
            ['kode' => 'MBG-002', 'kategori' => 'Protein', 'nama' => 'Daging Ayam Fresh', 'satuan' => 'Kg', 'stok' => 50],
            ['kode' => 'MBG-003', 'kategori' => 'Karbohidrat', 'nama' => 'Kentang', 'satuan' => 'Kg', 'stok' => 15],
            ['kode' => 'MBG-004', 'kategori' => 'Protein', 'nama' => 'Tempe', 'satuan' => 'Kg', 'stok' => 8],
            ['kode' => 'MBG-005', 'kategori' => 'Bumbu', 'nama' => 'Kecap Manis', 'satuan' => 'Liter', 'stok' => 70],
        ];
    }
}