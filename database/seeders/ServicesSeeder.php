<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\Service;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $services = [
            'Barbearia' => [
                [
                    'name' => 'Corte de Cabelo Tesoura',
                    'description' => '',
                    'price' => '30.00'
                ],
                [
                    'name' => 'Corte de Cabelo Maquina',
                    'description' => '',
                    'price' => '20.00'
                ],
                
                [
                    'name' => 'Corte de Cabelo Degrade',
                    'description' => '',
                    'price' => '35.00'
                ],
                [
                    'name' => 'Corte de Barba',
                    'description' => '',
                    'price' => '25.00'
                ]
            ],
            'Salão de Beleza' => [
                [
                    'name' => 'Corte de Cabelo Curto',
                    'description' => '',
                    'price' => '60.00'
                ],
                [
                    'name' => 'Corte de Cabelo Médio',
                    'description' => '',
                    'price' => '80.00'
                ],
                [
                    'name' => 'Corte de Cabelo Longo',
                    'description' => '',
                    'price' => '100.00'
                ]
            ],
            'Clinica de Estética' => [
                [
                    'name' => 'Limpeza de Pele',
                    'description' => '',
                    'price' => '60.00'
                ],
                [
                    'name' => 'Aplicação de botox',
                    'description' => '',
                    'price' => '80.00'
                ],
            ],
            'Maquiadora' => [
                [
                    'name' => 'Simples',
                    'description' => '',
                    'price' => '60.00'
                ],
                [
                    'name' => 'Casamento',
                    'description' => '',
                    'price' => '120.00'
                ],
                [
                    'name' => 'Noiva',
                    'description' => '',
                    'price' => '150.00'
                ],
            ],
        ];
        $accounts = Account::get();
        foreach ($accounts as $account){
            foreach($services[$account->activity] as $service){
                $service['account_id'] = $account->id;
                Service::create($service);
            }
        }
    }
}