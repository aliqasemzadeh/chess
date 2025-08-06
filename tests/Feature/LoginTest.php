<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;
use App\Livewire\Guest\Auth\Login;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_page_contains_livewire_component()
    {
        $this->get('/login')
            ->assertSuccessful()
            ->assertSeeLivewire('guest.auth.login');
    }

    /** @test */
    public function can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'name' => 'testuser',
            'password' => Hash::make('password123'),
        ]);

        Livewire::test(Login::class)
            ->set('username', 'testuser')
            ->set('password', 'password123')
            ->call('login')
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticated();
    }

    /** @test */
    public function shows_error_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'name' => 'testuser',
            'password' => Hash::make('password123'),
        ]);

        Livewire::test(Login::class)
            ->set('username', 'testuser')
            ->set('password', 'wrong-password')
            ->call('login')
            ->assertHasNoErrors()
            ->assertSee('The provided credentials do not match our records.');

        $this->assertGuest();
    }

    /** @test */
    public function username_is_required()
    {
        Livewire::test(Login::class)
            ->set('username', '')
            ->set('password', 'password123')
            ->call('login')
            ->assertHasErrors(['username' => 'required']);

        $this->assertGuest();
    }

    /** @test */
    public function password_is_required()
    {
        Livewire::test(Login::class)
            ->set('username', 'testuser')
            ->set('password', '')
            ->call('login')
            ->assertHasErrors(['password' => 'required']);

        $this->assertGuest();
    }
}
