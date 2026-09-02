<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class GoogleAuthTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Ensure owner role exists for tests
        Role::firstOrCreate(['name' => 'owner', 'guard_name' => 'web']);
    }

    public function test_redirect_to_google_without_credentials_redirects_with_warning()
    {
        Config::set('services.google.client_id', null);
        Config::set('services.google.client_secret', null);

        $response = $this->get(route('auth.google'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
    }

    public function test_redirect_to_google_with_credentials_initiates_oauth_redirect()
    {
        Config::set('services.google.client_id', 'test-client-id');
        Config::set('services.google.client_secret', 'test-client-secret');

        $driver = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
        $driver->shouldReceive('redirect')
            ->once()
            ->andReturn(redirect('https://accounts.google.com/o/oauth2/auth'));

        Socialite::shouldReceive('driver')->with('google')->andReturn($driver);

        $response = $this->get(route('auth.google'));

        $response->assertRedirect('https://accounts.google.com/o/oauth2/auth');
    }

    public function test_callback_creates_new_user_and_logs_in()
    {
        $email = 'newartisan_' . uniqid() . '@atelier.com';
        $mockSocialiteUser = Mockery::mock(SocialiteUser::class);
        $mockSocialiteUser->shouldReceive('getId')->andReturn('google-unique-' . uniqid());
        $mockSocialiteUser->shouldReceive('getEmail')->andReturn($email);
        $mockSocialiteUser->shouldReceive('getName')->andReturn('Savile Artisan');
        $mockSocialiteUser->shouldReceive('getNickname')->andReturn(null);
        $mockSocialiteUser->shouldReceive('getAvatar')->andReturn('https://lh3.googleusercontent.com/avatar.jpg');

        $driver = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
        $driver->shouldReceive('user')->once()->andReturn($mockSocialiteUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($driver);

        $response = $this->get(route('auth.google.callback'));

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'type' => 'owner',
        ]);

        $createdUser = User::where('email', $email)->first();
        $this->assertNotNull($createdUser->email_verified_at);
        $this->assertTrue(Auth::check());
        $this->assertEquals($createdUser->id, Auth::id());
        $this->assertTrue($createdUser->hasRole('owner'));

        // Since new owner has no shop_name, should redirect to onboarding details
        $response->assertRedirect(route('onboarding.business.details'));
    }

    public function test_callback_links_existing_user_by_email()
    {
        $email = 'existingtailor_' . uniqid() . '@atelier.com';
        $existingUser = User::create([
            'name' => 'Existing Tailor',
            'email' => $email,
            'password' => bcrypt('secret123'),
            'type' => 'owner',
            'shop_name' => 'Savile Row Tailors',
            'is_active' => 1,
            'subscription' => 1,
            'parent_id' => 1,
        ]);

        $googleId = 'google-id-' . uniqid();
        $mockSocialiteUser = Mockery::mock(SocialiteUser::class);
        $mockSocialiteUser->shouldReceive('getId')->andReturn($googleId);
        $mockSocialiteUser->shouldReceive('getEmail')->andReturn($email);
        $mockSocialiteUser->shouldReceive('getName')->andReturn('Existing Tailor');
        $mockSocialiteUser->shouldReceive('getNickname')->andReturn(null);
        $mockSocialiteUser->shouldReceive('getAvatar')->andReturn('https://avatar.google.com/pic.png');

        $driver = Mockery::mock('Laravel\Socialite\Two\GoogleProvider');
        $driver->shouldReceive('user')->once()->andReturn($mockSocialiteUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($driver);

        $response = $this->get(route('auth.google.callback'));

        $existingUser->refresh();
        $this->assertEquals($googleId, $existingUser->google_id);
        $this->assertNotNull($existingUser->email_verified_at);
        $this->assertTrue(Auth::check());
        $this->assertEquals($existingUser->id, Auth::id());

        // Since shop_name is set, should redirect to home/dashboard
        $response->assertRedirect('/home');
    }

    public function test_callback_handles_google_cancellation_gracefully()
    {
        $response = $this->get(route('auth.google.callback', ['error' => 'access_denied']));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
    }

    public function test_superadmin_can_save_google_oauth_credentials_in_dashboard()
    {
        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin_' . uniqid() . '@darzidesk.com',
            'password' => bcrypt('password123'),
            'type' => 'super admin',
            'is_active' => 1,
            'subscription' => 1,
            'parent_id' => 0,
        ]);

        $this->actingAs($superAdmin);

        $response = $this->post(route('setting.google.oauth'), [
            'google_oauth' => 'on',
            'google_client_id' => 'custom-google-client-id-12345.apps.googleusercontent.com',
            'google_client_secret' => 'GOCSPX-secretkey999888',
            'google_redirect_uri' => 'http://localhost:8000/auth/google/callback',
        ]);

        $response->assertSessionHas('success');
        $response->assertSessionHas('tab', 'google_oauth_settings');

        $this->assertDatabaseHas('settings', [
            'name' => 'google_client_id',
            'value' => 'custom-google-client-id-12345.apps.googleusercontent.com',
        ]);

        $this->assertDatabaseHas('settings', [
            'name' => 'google_client_secret',
            'value' => 'GOCSPX-secretkey999888',
        ]);
    }

    public function test_regular_owner_cannot_save_google_oauth_credentials()
    {
        $owner = User::create([
            'name' => 'Boutique Owner',
            'email' => 'boutique_owner_' . uniqid() . '@atelier.com',
            'password' => bcrypt('password123'),
            'type' => 'owner',
            'is_active' => 1,
            'subscription' => 1,
            'parent_id' => 1,
        ]);

        $this->actingAs($owner);

        $response = $this->post(route('setting.google.oauth'), [
            'google_oauth' => 'on',
            'google_client_id' => 'hacker-client-id',
            'google_client_secret' => 'hacker-secret',
        ]);

        $response->assertSessionHas('error');
    }
}
