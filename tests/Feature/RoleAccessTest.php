<?php

namespace Tests\Feature;

use App\Models\Bahan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    private function user(string $role): User
    {
        return User::factory()->create([
            'role' => $role,
            'status' => 'Aktif',
        ]);
    }

    private function bahan(): Bahan
    {
        return Bahan::create([
            'kode' => 'MBG-TEST',
            'nama' => 'Beras Test',
            'kategori' => 'Sembako',
            'stok' => 50,
            'satuan' => 'Kg',
        ]);
    }

    public function test_pengawas_can_view_inventory_page(): void
    {
        $pengawas = $this->user('Pengawas');

        $this->actingAs($pengawas)->get(route('bahan.index'))->assertOk();
        $this->actingAs($pengawas)->get(route('barang-masuk.index'))->assertOk();
        $this->actingAs($pengawas)->get(route('barang-keluar.index'))->assertOk();
        $this->actingAs($pengawas)->get(route('stok-opname.index'))->assertOk();
    }

    public function test_pengawas_cannot_create_update_or_delete_bahan(): void
    {
        $pengawas = $this->user('pengawas');
        $bahan = $this->bahan();

        $this->actingAs($pengawas)
        ->post(route('bahan.store'), [
            'nama' => 'Gula',
            'kategori' => 'Sembako',
            'stok' => 10,
            'satuan' => 'Kg',
        ])
        ->assertForbidden();

        $this->actingAs($pengawas)
        ->put(route('bahan.update', $bahan->kode), [
            'kode' => $bahan->kode,
            'nama' => 'Beras Diubah',
            'kategori' => 'Sembako',
            'stok' => 60,
            'satuan' => 'Kg',
        ])
        ->assertForbidden();

        $this->actingAs($pengawas)
        ->delete(route('bahan.destroy', $bahan->kode))
        ->assertForbidden();
    }

    public function test_pengawas_cannot_create_inventory_transaction(): void
    {
        $pengawas = $this->user('Pengawas');
        $bahan = $this->bahan();

        $this->actingAs($pengawas)
        ->post(route('barang-masuk.store'), [
            'tanggal' =>now()->toDateString(),
            'kode' => $bahan->kode,
            'jumlah' => 5,
            'supplier' => 'Test',
        ])
        ->assertForbidden();

        $this->actingAs($pengawas)
        ->post(route('barang-keluar.store'), [
            'tanggal' => now()->toDateString(),
            'kode' => $bahan->kode,
            'jumlah' => 5,
            'supplier' => 'Test',
        ])
        ->assertForbidden();

        $this->actingAs($pengawas)
        ->post(route('stok-opname.store'), [
            'bahan_id' => $bahan->id,
            'stok_fisik' => 45,
        ])
        ->assertForbidden();

        $this->assertSame(50, $bahan->fresh()->stok);
    }

    public function test_petugas_gudang_can_manage_inventory(): void
    {
        $petugas = $this->user('Petugas Gudang');
        $bahan = $this->bahan();

        $this->actingAs($petugas)
        ->post(route('bahan.store'), [
            'nama' => 'Gula',
            'kategori' => 'Sembako',
            'stok' => 10,
            'satuan' => 'Kg',
        ])
        ->assertRedirect(route('bahan.index'));

        $this->actingAs($petugas)
        ->post(route('barang-masuk.store'), [
            'tanggal' => now()->toDateString(),
            'kode' => $bahan->kode,
            'jumlah' => 5,
            'supplier' => 'Test',
        ])
        ->assertRedirect(route('barang-masuk.index'));

        $this->actingAs($petugas)
            ->post(route('barang-keluar.store'), [
                'tanggal' => now()->toDateString(),
                'kode' => $bahan->kode,
                'jumlah' => 5,
                'supplier' => 'Test',
            ])
            ->assertRedirect(route('barang-keluar.index'));

        $this->actingAs($petugas)
            ->post(route('stok-opname.store'), [
                'bahan_id' => $bahan->id,
                'stok_fisik' => 45,
            ])
            ->assertRedirect(route('stok-opname.index'));

        $this->assertSame(45, $bahan->fresh()->stok);
    }

    public function test_admin_still_sees_inventory_forms_and_actions(): void
    {
        $admin = $this->user('Admin');
        $this->bahan();

        $this->actingAs($admin)
            ->get(route('bahan.index'))
            ->assertSee('Tambah Bahan')
            ->assertSee('Aksi');

        $this->actingAs($admin)
            ->get(route('barang-masuk.index'))
            ->assertSee('Form Penerimaan');

        $this->actingAs($admin)
            ->get(route('barang-keluar.index'))
            ->assertSee('Form Pengeluaran');

        $this->actingAs($admin)
            ->get(route('stok-opname.index'))
            ->assertSee('Stok Fisik Gudang')
            ->assertSee('Sesuaikan');
    }

    public function test_pengawas_does_not_see_inventory_forms_and_actions(): void
    {
        $pengawas = $this->user('Pengawas');
        $this->bahan();

        $this->actingAs($pengawas)
            ->get(route('bahan.index'))
            ->assertDontSee('Tambah Bahan')
            ->assertDontSee('Aksi');

        $this->actingAs($pengawas)
            ->get(route('barang-masuk.index'))
            ->assertDontSee('Form Penerimaan');

        $this->actingAs($pengawas)
            ->get(route('barang-keluar.index'))
            ->assertDontSee('Form Pengeluaran');

        $this->actingAs($pengawas)
            ->get(route('stok-opname.index'))
            ->assertDontSee('Stok Fisik Gudang')
            ->assertDontSee('Sesuaikan');
    }
}
