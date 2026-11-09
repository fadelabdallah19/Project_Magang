<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\BarangMasuk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BarangMasukController extends Controller
{
    public function index(): View
    {
        $barangMasuk = BarangMasuk::with('bahan')
            ->latest('tanggal')
            ->latest('id')
            ->get();

        $bahan = Bahan::orderBy('nama')->get();

        return view('barang-masuk.index', compact('barangMasuk', 'bahan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'kode' => ['required', 'string', 'exists:bahan,kode'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'supplier' => ['nullable', 'string', 'max:100'],
        ]);

        $bahan = Bahan::where('kode', $validated['kode'])->firstOrFail();

        DB::transaction(function () use ($validated, $bahan) {
            BarangMasuk::create([
                'no_transaksi' => $this->nomorTransaksi(),
                'bahan_id' => $bahan->id,
                'tanggal' => $validated['tanggal'],
                'jumlah' => $validated['jumlah'],
                'satuan' => $bahan->satuan,
                'supplier' => $validated['supplier'] ?? null,
            ]);

            $bahan->increment('stok', $validated['jumlah']);
        });

        return redirect()
            ->route('barang-masuk.index')
            ->with('success', "Barang masuk \"{$bahan->nama}\" sebanyak {$validated['jumlah']} {$bahan->satuan} berhasil dicatat.");
    }

    private function nomorTransaksi(): string
    {
        $urutan = (int) BarangMasuk::max('id') + 1;

        return 'BM-' . now()->format('Ymd') . '-' . str_pad((string) $urutan, 4, '0', STR_PAD_LEFT);
    }
}