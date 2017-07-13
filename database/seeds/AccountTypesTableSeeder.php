<?php

use Illuminate\Database\Seeder;

class AccountTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $accountTypes = [
            ['description' => 'Cliente Potenziale'],
            ['description' => 'Rivenditore Attivo'],
            ['description' => 'Riservato Ardis'],
            ['description' => 'Cliente Attivo'],
        ];

        DB::table('account_types')->insert($accountTypes);
    }
}
