<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => "(".rand(30,50).") ".rand(88000,99999)."-".rand(1000,9999),
            'document' => ((rand(0,5) < 3) ? rand(10000000000, 99999999999) : rand(10000000000000, 99999999999999)),
        ];
    }
}
