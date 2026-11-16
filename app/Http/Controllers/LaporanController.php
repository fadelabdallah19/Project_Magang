<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $dari = $request->input('dari', now()->startOfMonth()->toDateString());
        $sampai = $request->input('sampai', now()->startOfMonth()->toDateString());

        $laporan = Bahan::query()
        ->when($request->filled('kategori'), function ($query) use ($request) {
            $query->where('kategori', $request->input('kategori'));
        })
        ->orderBy('kode')
        ->get();

        $ringkasan = [
            'jenis' => $laporan->count(),
            'masuk' => BarangMasuk::whereBetween('tanggal', [$dari, $sampai])->sum('jumlah'),
                // ->whereYear('tanggal', now()->year)
                // ->sum('jumlah'),
            'keluar' => BarangKeluar::whereBetween('tanggal', [$dari, $sampai])->sum('jumlah'),
                // ->whereYear('tanggal', now()->year)
                // ->sum('jumlah'),
            'status' => $laporan->contains(fn ($item) => $item->stok <= Bahan::STOCK_MINIMUM)
                ? 'Stok Rendah'
                : 'Aman',
        ];

        return view('laporan.index', compact('laporan', 'ringkasan'));
    }

    public function export(Request $request): StreamedResponse
    {
        $dari = $request->input('dari', now()->startOfMonth()->toDateString());
        $sampai = $request->input('sampai', now()->startOfMonth()->toDateString());

        $laporan = Bahan::query()
        ->when($request->filled('kategori'),  function ($query) use ($request) {
            $query->where('kategori', $request->input('kategori'));
        })
        ->orderBy('kode')
        ->get();

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
        }, 'Laporan Persediaan MBG Smart Stock' . now()->format('Y-m-d') . '.csv');
    }
}
