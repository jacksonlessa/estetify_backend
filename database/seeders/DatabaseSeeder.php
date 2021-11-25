<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            AccountSeeder::class, //create 10 accounts and 1 user for each account
            ServicesSeeder::class, //create services for each account
        ]);
    }
}
