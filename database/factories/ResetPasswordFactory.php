<?php

namespace Database\Factories;

use App\Models\ResetPassword;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ResetPasswordFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ResetPassword::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(),
            'token' => Str::random(10),
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }

//    public function unverified()
//    {
//        return $this->state(function (array $attributes) {
//            return [
//                'email_verified_at' => null,
//            ];
//        });
//    }
}
