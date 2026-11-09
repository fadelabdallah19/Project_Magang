<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\BarangKeluar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BarangKeluarController extends Controller
{
    public function index(): View
    {
        $barangKeluar = BarangKeluar::with('bahan')
            ->latest('tanggal')
            ->latest('id')
            ->get();

        $bahan = Bahan::orderBy('nama')->get();

        return view('barang-keluar.index', compact('barangKeluar', 'bahan'));
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

        if ($bahan->stok < $validated['jumlah']) {
            return back()
                ->withErrors(['jumlah' => "Stok {$bahan->nama} tidak mencukupi. Tersedia {$bahan->stok} {$bahan->satuan}."])
                ->withInput();
        }

        DB::transaction(function () use ($validated, $bahan) {
            BarangKeluar::create([
                'no_transaksi' => $this->nomorTransaksi(),
                'bahan_id' => $bahan->id,
                'tanggal' => $validated['tanggal'],
                'jumlah' => $validated['jumlah'],
                'satuan' => $bahan->satuan,
                'supplier' => $validated['supplier'] ?? null,
            ]);

            $bahan->decrement('stok', $validated['jumlah']);
        });

        return redirect()
            ->route('barang-keluar.index')
            ->with('success', "Pengeluaran \"{$bahan->nama}\" sebanyak {$validated['jumlah']} {$bahan->satuan} berhasil dicatat.");
    }

    private function nomorTransaksi(): string
    {
        $urutan = (int) BarangKeluar::max('id') + 1;

        return 'BK-' . now()->format('Ymd') . '-' . str_pad((string) $urutan, 4, '0', STR_PAD_LEFT);
    }
}