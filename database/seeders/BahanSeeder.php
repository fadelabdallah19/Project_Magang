<?php

namespace Database\Seeders;

use App\Models\Bahan;
use Illuminate\Database\Seeder;

class BahanSeeder extends Seeder
{
    public function run(): void
    {
        $daftar = [
            ['kode' => 'MBG-001', 'nama' => 'Beras', 'kategori' => 'Sembako', 'stok' => 120, 'satuan' => 'Kg'],
            ['kode' => 'MBG-002', 'nama' => 'Daging Ayam Fresh', 'kategori' => 'Protein', 'stok' => 50, 'satuan' => 'Kg'],
            ['kode' => 'MBG-003', 'nama' => 'Kentang', 'kategori' => 'Karbohidrat', 'stok' => 15, 'satuan' => 'Kg'],
            ['kode' => 'MBG-004', 'nama' => 'Tempe', 'kategori' => 'Protein', 'stok' => 8, 'satuan' => 'Pcs'],
            ['kode' => 'MBG-005', 'nama' => 'Kecap Manis', 'kategori' => 'Bumbu', 'stok' => 70, 'satuan' => 'Liter'],
        ];

        foreach ($daftar as $item) {
            Bahan::updateOrCreate(['kode' => $item['kode']], $item);
        }
    }
}