<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BahanController extends Controller
{
    public function index(Request $request): View
    {
        $bahan = Bahan::query()
        ->when($request->filled('q'), function ($query) use ($request) {
            $keyword = $request->string('q')->toString();

            $query->where(function ($sub) use ($keyword) {
                $sub->where('nama', 'like' ,"%{$keyword}%")
                ->orWhere('kode', 'like', "%{$keyword}%");
            });
        })
        ->when($request->filled('kategori'), fn ($query) => $query->where('kategori', $request->input('kategori')))
        ->orderBy('kode')
        ->paginate(10)
        ->withQueryString();

        $kategoriList = Bahan::query()
        ->select('kategori')
        ->distinct()
        ->orderBy('kategori')
        ->pluck('kategori');

        $kodeBaru = Bahan::generateKode();

        return view('bahan.index', compact('bahan', 'kategoriList', 'kodeBaru'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'string', 'max:50'],
            'stok' => ['required', 'integer', 'min:0'],
            'satuan' => ['required', 'string', 'max:20'],
        ]);

        $validated['kode'] = Bahan::generateKode();

        Bahan::create($validated);

        return redirect()
        ->route('bahan.index')
        ->with('success', "Bahan \"{$validated['nama']}\" berhasil ditambahkan.");
    }

    public function update(Request $request, string $kode): RedirectResponse
    {
        $bahan = Bahan::where('kode', $kode)->firstOrFail();

        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:20', Rule::unique('bahan', 'kode')->ignore($bahan->id)],
            'nama' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'string', 'max:50'],
            'stok' => ['required', 'integer', 'min:0'],
            'satuan' => ['required', 'string', 'max:20'],
        ]);

        $bahan->update($validated);

        return redirect()
        ->route('bahan.index')
        ->with('success', "Bahan \"{$bahan->nama}\" berhasil diperbarui.");
    }

    public function destroy(string $kode): RedirectResponse
    {
        $bahan = Bahan::where('kode', $kode)->firstOrFail();

        if ($bahan->barangMasuk()->exists() || $bahan->barangKeluar()->exists() || $bahan->stokOpname()->exists()) {
            return redirect()
            ->route('bahan.index')
            ->with('error', "Bahan \"{$bahan->nama}\" tidak bisa dihapus karena sudah punya riwayat transaksi.");
        }

        $nama = $bahan->nama;
        $bahan->delete();

        return redirect()
        ->route('bahan.index')
        ->with('success', "Bahan \"{$nama}\" berhasil dihapus.");
    }
}
