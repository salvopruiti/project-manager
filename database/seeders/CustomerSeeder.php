<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Company::create(['name' => 'Scalia Group srl'])
            ->customers()->createMany([
                ['first_name' => 'Giuseppe', 'last_name' => 'Lanzetta', 'email' => 'giuseppe.lanzetta@scaliagroup.com'],
                ['first_name' => 'Daniela', 'last_name' => 'Zichittella', 'email' => 'daniela.zichittella@scaliagroup.com'],
                ['first_name' => 'Roberta', 'last_name' => 'Caruana', 'email' => 'roberta.caruana@scaliagroup.com'],
                ['first_name' => 'Santi', 'last_name' => 'Nasello', 'email' => 'santi.nasello@scaliagroup.com'],
                ['first_name' => 'Rossella', 'last_name' => 'Scavio', 'email' => 'rossella.scavio@scaliagroup.com'],
            ]);

        Company::create(['name' => 'Conigliaro'])
            ->customers()->createMany([
                ['first_name' => 'Federico', 'last_name' => 'Conigliaro', 'email' => 'fconigliaro@supermercaticonigliaro.it'],
                ['first_name' => 'Luca', 'last_name' => 'Conigliaro', 'email' => 'lconigliaro@supermercaticonigliaro.it']
            ]);

        Company::create(['name' => 'Morettino'])
            ->customers()->createMany([
                ['first_name' => 'Salvo', 'last_name' => 'Randazzo', 'email' => 'professional@morettino.com']
            ]);
    }
}
