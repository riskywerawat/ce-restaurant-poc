<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
//            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
//            'password' => '$argon2id$v=19$m=1024,t=2,p=2$MHJWWjU4TTUvS1pjTFNTYw$DVKiQ5ldIhFXkntQ+TSmrB3OiX9Ms20t0GAgU8v9c/I', // password
            'password' => '$argon2id$v=19$m=1024,t=2,p=2$LjZ2czM2VjYzZWt2UE9YVA$Htzxan5AQAOHIBM3lVb1Py9GdeSFpzcZA0z4xUAFvgo', // nge1717nge
            'remember_token' => Str::random(10),
        ];
    }

    public function buyer()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => User::TYPE_BUYER,
                'pin' => '123456',
            ];
        });
    }

    public function seller()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => User::TYPE_SELLER,
                'pin' => '123456',
            ];
        });
    }
}
