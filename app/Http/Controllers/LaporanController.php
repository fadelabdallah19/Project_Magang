<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index(): View
    {
        $laporan = Bahan::orderBy('kode')->get();

        $ringkasan = [
            'jenis' => $laporan->count(),
            'masuk' => BarangMasuk::whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->sum('jumlah'),
            'keluar' => BarangKeluar::whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->sum('jumlah'),
            'status' => $laporan->contains(fn ($item) => $item->stok <= Bahan::STOCK_MINIMUM)
                ? 'Stok Rendah'
                : 'Aman',
        ];

        return view('laporan.index', compact('laporan', 'ringkasan'));
    }

    public function export(): StreamedResponse
    {
        $laporan = Bahan::orderBy('kode')->get();

        return response()->streamDownload(function () use ($laporan) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Kode', 'Nama Bahan', 'Kategori', 'Stok Akhir', 'Satuan']);

            foreach ($laporan as $item) {
                fputcsv($handle, [
                    $item->kode,
                    $item->nama,
                    $item->kategori,
                    $item->stok,
                    $item->satuan,
                ]);
            }

            fclose($handle);
        }, 'laporan-persediaan-' . now()->format('Y-m-d') . '.csv');
    }
}