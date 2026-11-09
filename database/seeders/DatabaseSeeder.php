<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $akun = [
            ['name' => 'Administrator', 'username' => 'admin.mbg', 'email' => 'admin@mbg.test', 'role' => 'Admin'],
            ['name' => 'Petugas Gudang', 'username' => 'petugas.gudang', 'email' => 'gudang@mbg.test', 'role' => 'Petugas Gudang'],
            ['name' => 'Pimpinan', 'username' => 'pimpinan', 'email' => 'pimpinan@mbg.test', 'role' => 'Pengawas'],
        ];

        foreach ($akun as $item) {
            User::updateOrCreate(
                ['username' => $item['username']],
                [...$item, 'status' => 'Aktif', 'password' => 'password'],
            );
        }

        // Akun lama
        User::where('username', 'admin')->update([
            'role' => 'Admin',
            'status' => 'Aktif',
        ]);

        $this->call(BahanSeeder::class);
    }
}
