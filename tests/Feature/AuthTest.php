<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('লগইন করুন');
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('নতুন সদস্য নিবন্ধন');
    }

    public function test_user_can_register_and_receives_member_role(): void
    {
        $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);

        $response = $this->post('/register', [
            'name' => 'নতুন সদস্য',
            'email' => 'newmember@example.com',
            'phone' => '01711223344',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();

        $user = User::where('email', 'newmember@example.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('member'));
        $this->assertEquals('active', $user->status);
    }

    public function test_user_can_register_with_optional_photo(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');
        $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);

        $file = \Illuminate\Http\UploadedFile::fake()->image('avatar.jpg');

        $response = $this->post('/register', [
            'name' => 'ছবিসহ ইউজার',
            'email' => 'photo_user@example.com',
            'phone' => '01755667788',
            'photo' => $file,
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();

        $user = User::where('email', 'photo_user@example.com')->first();
        $this->assertNotNull($user);
        $this->assertNotNull($user->photo);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($user->photo);
    }

    public function test_user_can_login_with_email_or_phone(): void
    {
        $user = User::create([
            'name' => 'টেস্ট ইউজার',
            'email' => 'loginuser@example.com',
            'phone' => '01799887766',
            'password' => bcrypt('password123'),
            'status' => 'active',
        ]);

        // Login with email
        $response = $this->post('/login', [
            'login' => 'loginuser@example.com',
            'password' => 'password123',
        ]);
        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);

        auth()->logout();

        // Login with phone
        $response = $this->post('/login', [
            'login' => '01799887766',
            'password' => 'password123',
        ]);
        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_inactive_user_cannot_login(): void
    {
        User::create([
            'name' => 'নিষ্ক্রিয় ইউজার',
            'email' => 'inactive@example.com',
            'phone' => '01700000000',
            'password' => bcrypt('password123'),
            'status' => 'inactive',
        ]);

        $response = $this->post('/login', [
            'login' => 'inactive@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('login');
        $this->assertGuest();
    }

    public function test_forgot_password_screen_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');
        $response->assertStatus(200);
        $response->assertSee('পাসওয়ার্ড ভুলে গেছেন?');
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        $response = $this->get('/reset-password/sample-token?email=user@example.com');
        $response->assertStatus(200);
        $response->assertSee('নতুন পাসওয়ার্ড সেট করুন');
    }
}
