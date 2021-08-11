<?php

namespace Tests\Feature;

use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call("passport:install");
    }

    public function testRegister()
    {
        $data = [
            'email' => 'exmple@exe',
            'name' => 'name',
            'password' => 'pass',
            'password_confirmation' => 'pass',
        ];

        $response = $this->json('POST', '/api/user', $data)->assertStatus(201);
        $response->assertJsonStructure([
            'token'
        ]);
    }

    public function testLogin()
    {
        $data['email'] = 'exmple@exe';
        $data['password'] = Hash::make('pass');
        User::factory()->create($data);

        $data = [
            'email' => 'exmple@exe',
            'password' => 'pass',
        ];

        $response = $this->json('POST', '/api/user/login', $data)->assertStatus(200);
        $response->assertJsonStructure([
            'token'
        ]);
    }

    public function testReset()
    {
        $data['email'] = 'exmple@exe';
        $data['password'] = Hash::make('pass');
        User::factory()->create($data);

        $data = [
            'email' => 'exmple@exe',
        ];

        $response = $this->json('POST', '/api/user/reset', $data)->assertStatus(200);
        $response->assertExactJson([
            'success' => true
        ]);
    }
}
