<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        //Data Dummy
        $bahan =[
            ['kode' => 'MBG-001', 'nama' => 'Beras', 'stok' => 120, 'satuan' => 'Kg', 'status' => 'Aman'],
            ['kode' => 'MBG-002', 'nama' => 'Daging Ayam Fresh', 'stok' => 50, 'satuan' => 'Kg', 'status' => 'Aman'],
            ['kode' => 'MBG-003', 'nama' => 'Kentang', 'stok' => 15, 'satuan' => 'Kg', 'status' => 'Stok Rendah'],
            ['kode' => 'MBG-005', 'nama' => 'Tempe', 'stok' => 8, 'satuan' => 'Kg', 'status' => 'Stok Rendah'],
            ['kode' => 'MBG-004', 'nama' => 'Kecap Manis', 'stok' => 70, 'satuan' => 'Liter', 'status' => 'Aman'],
        ];

        return view('dashboard', [
            'totalBahan' => 5,
            'stokRendah' => 3,
            'transaksiHariIni' => 2,
            'bahan' => $bahan,
        ]);
    }
}