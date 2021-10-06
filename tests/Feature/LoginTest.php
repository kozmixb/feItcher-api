<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use DatabaseTransactions,
        DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->artisan('passport:install');
    }

    /**
     * Test login with no payload
     *
     * @return void
     */
    public function testValidation()
    {

        $response = $this->postJson('/api/login', []);

        $response
            ->assertStatus(422)
            ->assertJson(["message" => "The given data was invalid."]);
    }

    /**
     * Test login with no payload
     *
     * @return void
     */
    public function testInvalidPayload()
    {
        $payload = ['email' => 'new@email.com', 'password' => Str::random('8')];
        $response = $this->post('/api/login', $payload);

        $response
            ->assertJson(["message" => "Invalid login credentials"])
            ->assertStatus(400);
    }

    /**
     * Test login with no payload
     *
     * @return void
     */
    public function testSuccessfulLogin()
    {
        $user = User::find(1);
        $password = Str::random('10');
        $user->password = bcrypt($password);
        $user->save();

        $clientId = env('CLIENT_ID');
        $clientSecret = env('CLIENT_SECRET');
        DB::table('oauth_clients')
            ->where('id', $clientId)
            ->update(['secret' => $clientSecret]);

        $payload = [
            'email' => $user->email,
            'password' => $password
        ];

        $response = $this->post('/api/login', $payload);

        $response
            ->assertJsonStructure(['access_token', 'expires_in'])
            ->assertStatus(200);
    }
}
