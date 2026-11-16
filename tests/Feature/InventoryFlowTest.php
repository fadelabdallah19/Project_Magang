<?php

namespace Tests\Feature;

use App\Models\Bahan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryFlowTest extends TestCase
{
    use RefreshDatabase;

    private function user(): User
    {
        return User::factory()->create([
            'role' => 'Petugas Gudang',
            'status' => 'Aktif',
        ]);
    }

    private function bahan(int $stok = 50): Bahan
    {
        return Bahan::create([
            'kode' => 'MBG-TEST',
            'nama' => 'Beras Test',
            'kategori' => 'Sembako',
            'stok' => $stok,
            'satuan' => 'Kg',
        ]);
    }

    public function test_barang_masuk_increases_stock(): void
    {
        $bahan = $this->bahan(10);

        $response = $this->actingAs($this->user())->post(route('barang-masuk.store'), [
            'tanggal' => '2026-11-13',
            'kode' => $bahan->kode,
            'jumlah' => 5,
            'supplier' => 'Pemasok Test',
        ]);

        $response->assertRedirect(route('barang-masuk.index'));

        $this->assertDatabaseHas('barang_masuk', [
            'bahan_id' => $bahan->id,
            'jumlah' => 5,
        ]);

        $this->assertSame(15, $bahan->fresh()->stok);
    }

    public function test_barang_keluar_decreases_stock(): void
    {
        $bahan = $this->bahan(20);

        $response = $this->actingAs($this->user())->post(route('barang-keluar.store'), [
            'tanggal' => '2026-11-13',
            'kode' => $bahan->kode,
            'jumlah' => 7,
            'supplier' => 'Dapur Produksi',
        ]);

        $response->assertRedirect(route('barang-keluar.index'));

        $this->assertDatabaseHas('barang_keluar', [
            'bahan_id' => $bahan->id,
            'jumlah' => 7,
        ]);

        $this->assertSame(13, $bahan->fresh()->stok);
    }

    public function test_barang_keluar_rejected_when_stock_is_not_enough(): void
    {
        $bahan = $this->bahan(3);

        $response = $this->actingAs($this->user())
            ->from(route('barang-keluar.index'))
            ->post(route('barang-keluar.store'), [
                'tanggal' => '2026-11-13',
                'kode' => $bahan->kode,
                'jumlah' => 5,
            ]);

        $response->assertRedirect(route('barang-keluar.index'));
        $response->assertSessionHasErrors('jumlah');

        $this->assertSame(3, $bahan->fresh()->stok);
        $this->assertDatabaseCount('barang_keluar', 0);
    }

    public function test_stok_opname_updates_stock_and_records_difference(): void
    {
        $bahan = $this->bahan(10);

        $response = $this->actingAs($this->user())->post(route('stok-opname.store'), [
            'bahan_id' => $bahan->id,
            'stok_fisik' => 8,
        ]);

        $response->assertRedirect(route('stok-opname.index'));

        $this->assertSame(8, $bahan->fresh()->stok);

        $this->assertDatabaseHas('stok_opname', [
            'bahan_id' => $bahan->id,
            'stok_sistem' => 10,
            'stok_fisik' => 8,
            'selisih' => -2,
        ]);
    }
}
