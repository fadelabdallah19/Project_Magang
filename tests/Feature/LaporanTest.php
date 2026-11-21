<?php

namespace Tests\Feature;

use App\Models\Bahan;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanTest extends TestCase
{
    use RefreshDatabase;

    private function user(): User
    {
        return User::factory()->create([
            'role' => 'Pengawas',
            'status' => 'Aktif',
        ]);
    }

    private function bahan(string $kode, string $nama, string $kategori, int $stok = 100): Bahan
    {
        return Bahan::create([
            'kode' => $kode,
            'nama' => $nama,
            'kategori' => $kategori,
            'stok' => $stok,
            'satuan' => 'Kg',
        ]);
    }

    private function barangMasuk(Bahan $bahan, string $tanggal, int $jumlah): void
    {
        BarangMasuk::create([
            'no_transaksi' => 'BM-' . $bahan->kode . '-' . $tanggal,
            'bahan_id' => $bahan->id,
            'tanggal' => $tanggal,
            'jumlah' => $jumlah,
            'satuan' => $bahan->satuan,
            'supplier' => 'Test',
        ]);
    }

    private function barangKeluar(Bahan $bahan, string $tanggal, int $jumlah): void
    {
        BarangKeluar::create([
            'no_transaksi' => 'BK-' . $bahan->kode . '-' . $tanggal,
            'bahan_id' => $bahan->id,
            'tanggal' => $tanggal,
            'jumlah' => $jumlah,
            'satuan' => $bahan->satuan,
            'supplier' => 'Test',
        ]);
    }

    public function test_laporan_defaults_to_current_month(): void
    {
        $response = $this->actingAs($this->user())->get(route('laporan.index'));

        $response->assertOk();
        $response->assertViewHas('dari', now()->startOfMonth()->toDateString());
        $response->assertViewHas('sampai', now()->toDateString());
    }

    public function test_laporan_can_be_filtered_by_date_and_category(): void
    {
        $beras = $this->bahan('MBG-001', 'Beras', 'Sembako');
        $bayam = $this->bahan('MBG-002', 'Bayam', 'Sayur');

        $this->barangMasuk($beras, '2026-11-03', 10);
        $this->barangMasuk($bayam, '2026-11-03', 7);
        $this->barangMasuk($beras, '2026-10-31', 99);
        $this->barangKeluar($beras, '2026-11-04', 4);
        $this->barangKeluar($bayam, '2026-11-04', 2);

        $response = $this->actingAs($this->user())->get(route('laporan.index', [
            'dari' => '2026-11-01',
            'sampai' => '2026-11-07',
            'kategori' => 'Sembako',
        ]));

        $response->assertOk();
        $response->assertViewHas('dari', '2026-11-01');
        $response->assertViewHas('sampai', '2026-11-07');
        $response->assertViewHas('kategori', 'Sembako');
        $response->assertViewHas('laporan', function ($laporan) {
            return $laporan->count() === 1
                && $laporan->first()->kode === 'MBG-001';
        });
        $response->assertViewHas('ringkasan', function (array $ringkasan) {
            return $ringkasan['jenis'] === 1
                && (int) $ringkasan['masuk'] === 10
                && (int) $ringkasan['keluar'] === 4;
        });
    }

    public function test_laporan_rejects_end_date_before_start_date(): void
    {
        $this->actingAs($this->user())
            ->from(route('laporan.index'))
            ->get(route('laporan.index', [
                'dari' => '2026-11-10',
                'sampai' => '2026-11-01',
            ]))
            ->assertRedirect(route('laporan.index'))
            ->assertSessionHasErrors('sampai');
    }

    public function test_laporan_shows_quick_filter_buttons(): void
    {
        $this->actingAs($this->user())
            ->get(route('laporan.index'))
            ->assertOk()
            ->assertSee('Hari Ini')
            ->assertSee('7 Hari Terakhir')
            ->assertSee('Bulan Ini');
    }

    public function test_laporan_export_contains_period_and_totals(): void
    {
        $beras = $this->bahan('MBG-001', 'Beras', 'Sembako');

        $this->barangMasuk($beras, '2026-11-03', 10);
        $this->barangKeluar($beras, '2026-11-04', 4);

        $response = $this->actingAs($this->user())->get(route('laporan.export', [
            'dari' => '2026-11-01',
            'sampai' => '2026-11-07',
            'kategori' => 'Sembako',
        ]));

        $response->assertOk();
        $content = $response->streamedContent();

        $this->assertStringContainsString('Periode,2026-11-01,s/d,2026-11-07', $content);
        $this->assertStringContainsString('Kategori,Sembako', $content);
        $this->assertStringContainsString('Kode,"Nama Bahan",Kategori,"Stok Akhir",Satuan,"Masuk (periode)","Keluar (periode)",Status', $content);
        $this->assertStringContainsString('Beras,Sembako,100,Kg,10,4,Aman', $content);
    }
}
