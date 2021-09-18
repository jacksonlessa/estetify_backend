<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->unique()->company;
        $activities = [
            'Barbearia',
            'Salão de Beleza',
            'Clinica de Estética',
            'Maquiadora'
        ];
        shuffle($activities);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'document' => ((rand(0,5) < 3) ? rand(10000000000, 99999999999) : rand(10000000000000, 99999999999999)),
            'activity_type' => $activities[0],
            'phone' => "(".rand(30,50).") ".rand(88000,99999)."-".rand(1000,9999),
            'beta_test' => rand(0,1),
        ];
    }
}
