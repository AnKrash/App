<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function testCreate()
    {
        $data = [
            'email' => 'exmple@exe',
            'name' => 'name',
            'password' => 'pass'
        ];

        $service = new UserService();
        $user = $service->create($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', ['email' => 'exmple@exe']);
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @dataProvider loginProvider
     */
    public function testLogin(string $email, string $password = '')
    {
        $data['email'] = 'email@email';
        $data['password'] = '$2y$10$6tHbQJQzyaVh96hRzVl.feBdNBAFdcIYmjy2Um0f07yhyb0eZk4hy';
        User::factory()->create($data);

        $data['password'] = $password;
        $data['email'] = $email;
        $service = new UserService();
        $user =$service->login($data);
        if ($password === '') {
            $this->assertNull($user);
            return;
        }

        $this->assertInstanceOf(User::class, $user);
    }

    public function loginProvider(): array
    {
        return [
            //first run of testLogin
            [
                'email@email',
                '34567sg',
            ],
            //second run of testLogin
            [
                'test@test'
            ],
            //third run of testLogin
            [
                'email@email',
            ],
        ];
    }
}
