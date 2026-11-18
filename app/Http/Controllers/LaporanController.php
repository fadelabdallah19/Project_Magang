<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        [$dari, $sampai, $kategori] = $this->filters($request);
        $laporan = $this->laporanQuery($kategori)->get();
        $ringkasan = [
            'jenis' => $laporan->count(),
            'masuk' => BarangMasuk::query()
            ->when($kategori, fn (Builder $query) => $query->whereHas (
                'bahan',
                fn (Builder $bahan) => $bahan->where('kategori', $kategori),
            ))
            ->whereDate('tanggal', '>=', $dari)
            ->whereDate('tanggal', '<=', $sampai)
            ->sum('jumlah'),
            'keluar' => BarangKeluar::query()
            ->when($kategori, fn (Builder $query) => $query->whereHas (
                'bahan',
                fn (Builder $bahan) => $bahan->where('kategori', $kategori),
            ))
            ->whereDate('tanggal', '>=', $dari)
            ->whereDate('tanggal', '<=', $sampai)
            ->sum('jumlah'),
            'status' => $laporan->contains(fn ($item) => $item->stok <= Bahan::STOCK_MINIMUM)
            ? 'Stok Rendah'
            : 'Aman'
        ];

        $kategoriList = $this->kategoriList();

        return view('laporan.index', compact('laporan', 'ringkasan', 'dari', 'sampai', 'kategori', 'kategoriList', ));
    }

    public function export(Request $request): StreamedResponse
    {
        [$dari, $sampai, $kategori] = $this->filters($request);
        $laporan = $this->laporanQuery($kategori)
        ->withSum([
            'barangMasuk as total_masuk' => fn (Builder $query) => $query
            ->whereDate('tanggal', '>=', $dari)
            ->whereDate('tanggal', '<=', $sampai),
        ], 'jumlah')
        ->withSum([
            'barangKeluar as total_keluar' => fn (Builder $query) => $query
            ->whereDate('tanggal', '>=', $dari)
            ->whereDate('tanggal', '<=', $sampai),
        ], 'jumlah')
        ->get();

        $namaFile = 'Laporan Persediaan MBG Smart Stock'.$dari.'-sd-'.$sampai.'.csv';

        return response()->streamDownload(function () use ($laporan, $dari, $sampai, $kategori) {

            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['laporan Persediaan MBG Smart Stock']);
            fputcsv($handle, ['Periode', $dari, 's/d', $sampai]);
            fputcsv($handle, ['Kategori', $kategori ?: 'Semua Kategori']);
            fwrite($handle, PHP_EOL);
            fputcsv($handle, ['Kode', 'Nama Bahan', 'Kategori', 'Stok Akhir', 'Satuan', 'Masuk (periode)', 'Keluar (periode)', 'Status', ]);

            foreach ($laporan as $item) {
                fputcsv($handle, [
                    $item->kode,
                    $item->nama,
                    $item->kategori,
                    $item->stok,
                    $item->satuan,
                    (int) ($item->total_masuk ?? 0),
                    (int) ($item->total_keluar ?? 0),
                    $item->status,
                ]);
            }
            fclose($handle);
        }, $namaFile);
    }

    private function filters(Request $request): array
    {
        $validated = $request->validate([
            'dari' => ['nullable', 'date'],
            'sampai' => ['nullable', 'date'],
            'kategori' => ['nullable', 'string', 'max:50'],
        ]);

        $dari = $validated['dari'] ?? now()->startOfMonth()->toDateString();
        $sampai = $validated['sampai'] ?? now()->toDateString();

        if (Carbon::parse($sampai)->lt(Carbon::parse($dari))) {
            throw ValidationException::withMessages([
                'sampai' => 'Tanggal akhir tidak boleh lebih dari awal dari tanggal mulai.',
            ]);
        }
        return [$dari, $sampai, $validated['kategori'] ?? null];
    }

    private function laporanQuery(?string $kategori): Builder
    {
        return Bahan::query()
        ->when($kategori, fn (Builder $query) => $query->where('kategori', $kategori))
        ->orderBy('kode');
    }

    private function kategoriList(): Collection
    {
        return Bahan::query()
        ->select('kategori')
        ->distinct()
        ->orderBy('kategori')
        ->pluck('kategori');
    }
}
