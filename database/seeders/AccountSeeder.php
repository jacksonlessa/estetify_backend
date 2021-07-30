<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Account::factory()
            ->count(10)
            ->hasUsers(1)
            ->hasClients(50)
            ->create();
    }
}
