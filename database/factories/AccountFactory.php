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
        $plan_id = rand(1,3);
        $featuresByPlan = [
            1 => ["professionals"=>1,"services"=>true,"products"=>false],
            2 => ["professionals"=>5,"services"=>true,"products"=>false],
            3 => ["professionals"=>10,"services"=>true,"products"=>true],
        ];
        shuffle($activities);
        return [
            'name' => $name,
            // 'slug' => Str::slug($name),
            'document' => ((rand(0,5) < 3) ? rand(10000000000, 99999999999) : rand(10000000000000, 99999999999999)),
            'activity' => $activities[0],
            'phone' => "(".rand(30,50).") ".rand(88000,99999)."-".rand(1000,9999),
            "plan_id" => $plan_id,
            "features" => json_encode($featuresByPlan[$plan_id])
        ];
    }
}
