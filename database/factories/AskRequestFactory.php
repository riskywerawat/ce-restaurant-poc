<?php

namespace Database\Factories;

use App\Models\AskRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class AskRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AskRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'delivery_date' => $this->faker->date('Y-m-d', '+1 year'),
            'status' => AskRequest::STATUS_ACTIVE,
            'quantity' => 100,
            'quantity_matched' => 0,
            'quantity_pending' => 100,
            'price' => 1000000, // 10,000 THB
            'fee' => 3, // 3%
        ];
    }
}
