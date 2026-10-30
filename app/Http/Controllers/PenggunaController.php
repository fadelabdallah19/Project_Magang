<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PenggunaController extends Controller
{
    public function index(): View
    {
        $pengguna = $this->data();

        return view('pengguna.index', compact('pengguna'));
    }

    private function data(): array
    {
        return [
            [
                'nama' => 'Fadel Abdallah',
                'username' => 'admin_fadel',
                'role' => 'Admin',
                'status' => 'Aktif'
            ],

            [
                'nama' => 'Kamar Pelajar',
                'username' => 'gudang_kp',
                'role' => 'Petugas Gudang',
                'status' => 'Aktif',
            ],

            [
                'nama' => 'Esa Unggul',
                'username' => 'pengawas_esa',
                'role' => 'Pengawas',
                'status' => 'Aktif',
            ],
        ];
    }
}
