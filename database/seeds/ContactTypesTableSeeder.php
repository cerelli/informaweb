<?php

use Illuminate\Database\Seeder;

class ContactTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $contactTypes = [
            ['description' => 'Centralino'],
            ['description' => 'Titolare'],
            ['description' => 'Dipendente'],
        ];

        DB::table('contact_types')->insert($contactTypes);
    }
}
