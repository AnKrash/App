<?php

namespace Tests\Unit;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Services\UserService;
use Carbon\Carbon;
use  App\Models\ResetPassword;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
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
        $user = $service->login($data);
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

    public function testReset()
    {
        //todo add user into db
        $data = [
            'email' => 'exmple@exe',
        ];
        $service = new UserService();
        $result = $service->reset($data);

        Mail::fake();

        $this->assertTrue($result);

        //todo check by user_id
        $this->assertDatabaseHas('reset_passwords', ['email' => 'exmple@exe']);
        Mail::assertSent(ResetPasswordMail::class);
    }

    /**
     * @param string $token
     * @param int $userId
     * @param Carbon $createdAt
     * @param bool $expected
     *
     * @dataProvider newPassProvider
     */
    public function testNewPass(string $token, int $userId, Carbon $createdAt, bool $expected = false)
    {
        User::factory()->create([
            'password' => "123",
        ]);

        //prepare conditions
        ResetPassword::factory()->create([
            'user_id' => $userId,
            'token' => "123",
            'created_at' => $createdAt
        ]);

        $data = ['password' => "123456", 'token' => $token];

        //run method
        $service = new UserService();
        $result = $service->newPass($data);

        //make assertions
       $this->assertEquals($expected, $result);
//        if ($expected) {
//            // todo check password was changed and check reset_passwords record was removed
//            // $this->assertDatabaseHas('user', ['password' => 'exmple@exe']);
//             $this->assertDatabaseMissing('reset_passwords',['password'=>'123456']);
//        }
    }

    public function newPassProvider(): array
    {
        return [
            // incorrect token
            [
                'fakeToken',
                1,
                Carbon::now(),
            ],
            // no user in db
            [
                '123',
                2,
                Carbon::now(),
            ],
            //incorrect token created_at time
            [
                '123',
                1,
                Carbon::now()->subDay(),
            ],
            // correct data
            [
                '123',
                1,
                Carbon::now(),
                true
            ],
        ];
    }
}
