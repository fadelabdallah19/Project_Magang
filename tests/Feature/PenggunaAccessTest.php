<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PenggunaAccessTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create([
            'role' => 'Admin',
            'status' => 'Aktif',
        ]);
    }

    public function test_non_admin_cannot_access_pengguna_page(): void
    {
        $user = User::factory()->create([
            'role' => 'Petugas Gudang',
            'status' => 'Aktif',
        ]);

        $this->actingAs($user)
            ->get(route('pengguna.index'))
            ->assertForbidden();
    }

    public function test_admin_can_access_pengguna_page(): void
    {
        $this->actingAs($this->admin())
            ->get(route('pengguna.index'))
            ->assertOk();
    }

    public function test_admin_can_create_user(): void
    {
        $response = $this->actingAs($this->admin())->post(route('pengguna.store'), [
            'name' => 'Petugas Baru',
            'username' => 'petugas.baru',
            'email' => 'petugas.baru@example.test',
            'role' => 'Petugas Gudang',
            'status' => 'Aktif',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('pengguna.index'));

        $this->assertDatabaseHas('users', [
            'username' => 'petugas.baru',
            'role' => 'Petugas Gudang',
            'status' => 'Aktif',
        ]);
    }

    public function test_admin_cannot_delete_own_account(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)
            ->from(route('pengguna.index'))
            ->delete(route('pengguna.destroy', $admin));

        $response->assertRedirect(route('pengguna.index'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
        ]);
    }
}
