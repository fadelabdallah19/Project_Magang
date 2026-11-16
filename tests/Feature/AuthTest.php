<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_active_account(): void
    {
        $user = User::factory()->create([
            'username' => 'petugas',
            'password' => 'password',
            'status' => 'Aktif',
        ]);

        $response = $this->post(route('login.store'), [
            'username' => 'petugas',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_wrong_password(): void
    {
        User::factory()->create([
            'username' => 'petugas',
            'password' => 'password',
        ]);

        $response = $this->from(route('login'))->post(route('login.store'), [
            'username' => 'petugas',
            'password' => 'salah',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    public function test_inactive_user_cannot_login(): void
    {
        User::factory()->create([
            'username' => 'petugas',
            'password' => 'password',
            'status' => 'Nonaktif',
        ]);

        $response = $this->from(route('login'))->post(route('login.store'), [
            'username' => 'petugas',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
