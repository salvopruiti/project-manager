<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['name' => 'Salvatore Pruiti', 'email' => 'salvatore.pruiti@scaliagroup.com', 'password' => bcrypt('password')]);
        User::create(['name' => 'Alfredo Meschis', 'email' => 'alfredo.meschis@scaliagroup.com', 'password' => bcrypt('password')]);
    }
}
