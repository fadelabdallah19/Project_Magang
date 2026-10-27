<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StokOpnameController extends Controller
{
    public function index(): View
    {
        $stok =[
            ['nama' => 'Beras (Kg)', 'sistem' => 120],
            ['nama' => 'Kecap Manis (Liter)', 'sistem' => 50],
            ['nama' => 'Tempe (Kg)', 'sistem' => 70],
            ['nama' => 'Kentang (Kg)', 'sistem' => 80],
            ['nama' => 'Daging Ayam Fresh (Kg)', 'sistem' => 15],
        ];

        return view('stok-opname.index', compact('stok'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'stok_fisik' => ['required', 'integer', 'min:0'],
        ]);

        return redirect()
        ->route('stok-opname.index')
        ->with('success', "Stok fisik \"{$validated['nama']}\" berhasil disesuaikan menjadi {$validated['stok_fisik']}.");
    }
}