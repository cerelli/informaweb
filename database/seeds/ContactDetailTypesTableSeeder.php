<?php

use Illuminate\Database\Seeder;

class ContactDetailTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $contactDetailTypes = [
            ['description' => 'Casa'],
            ['description' => 'Ufficio'],
            ['description' => 'Privato'],
        ];

        DB::table('contact_detail_types')->insert($contactDetailTypes);
    }
}
