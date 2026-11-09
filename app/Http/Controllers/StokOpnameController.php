<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\StokOpname;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StokOpnameController extends Controller
{
    public function index(): View
    {
        $stok = Bahan::orderBy('nama')->get();
        
        return view('stok-opname.index', compact('stok'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bahan_id' => ['required', 'exists:bahan,id'],
            'stok_fisik' => ['required', 'integer', 'min:0'],
        ]);

        $bahan = Bahan::findOrFail($validated['bahan_id']);
        $selisih = $validated['stok_fisik'] - $bahan->stok;

        DB::transaction(function () use ($validated, $bahan, $selisih) {
            StokOpname::create([
                'bahan_id' => $bahan->id,
                'tanggal' => today(),
                'stok_sistem' => $bahan->stok,
                'stok_fisik' => $validated['stok_fisik'],
                'selisih' => $selisih,
                'keterangan' => $selisih === 0 ? 'Tidak ada selisih' : 'Penyesuaian stok opname',
            ]);

            $bahan->update(['stok' => $validated['stok_fisik']]);
        });

        return redirect()
        ->route('stok-opname.index')
         ->with('success', "Stok \"{$bahan->nama}\" berhasil disesuaikan menjadi {$validated['stok_fisik']} {$bahan->satuan}.");
    }
}