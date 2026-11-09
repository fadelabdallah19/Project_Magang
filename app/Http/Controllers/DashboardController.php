<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\StokOpname;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $bahan = Bahan::orderBy('kode')->get();
        $totalBahan = Bahan::count();
        $stokRendah = Bahan::where('stok', '<=', Bahan::STOCK_MINIMUM)->count();
        $penerimaanHariIni = BarangMasuk::whereDate('tanggal', today())->count();
        $pengeluaranHariIni = BarangKeluar::whereDate('tanggal', today())->count();
        $aktivitas = $this->aktivitasTerakhir();

        return view('dashboard', compact(
            'bahan',
            'totalBahan',
            'stokRendah',
            'penerimaanHariIni',
            'pengeluaranHariIni',
            'aktivitas',
        ));
    }

    private function aktivitasTerakhir(): Collection
    {
        $masuk = BarangMasuk::with('bahan')
            ->latest('created_at')
            ->take(3)
            ->get()
            ->map(fn ($item) => [
                'judul' => 'Penerimaan ' . $item->bahan->nama,
                'deskripsi' => $item->supplier
                    ? $item->supplier . ' mengirim pasokan.'
                    : $item->jumlah . ' ' . $item->satuan . ' diterima.',
                'waktu' => $item->created_at,
                'ikon' => 'masuk',
            ]);

        $keluar = BarangKeluar::with('bahan')
            ->latest('created_at')
            ->take(3)
            ->get()
            ->map(fn ($item) => [
                'judul' => 'Pengeluaran ' . $item->bahan->nama,
                'deskripsi' => $item->jumlah . ' ' . $item->satuan . ' dikeluarkan dari gudang.',
                'waktu' => $item->created_at,
                'ikon' => 'keluar',
            ]);

        $opname = StokOpname::with('bahan')
            ->latest('created_at')
            ->take(3)
            ->get()
            ->map(fn ($item) => [
                'judul' => 'Stok Opname ' . $item->bahan->nama,
                'deskripsi' => $item->keterangan ?: 'Penyesuaian fisik gudang utama.',
                'waktu' => $item->created_at,
                'ikon' => 'opname',
            ]);

        return $masuk
            ->concat($keluar)
            ->concat($opname)
            ->sortByDesc('waktu')
            ->take(3)
            ->values();
    }
}