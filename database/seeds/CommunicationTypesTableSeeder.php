<?php

use Illuminate\Database\Seeder;

class CommunicationTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $communicationTypes = [
            ['description' => 'Cellulare'],
            ['description' => 'eMail'],
            ['description' => 'Fax'],
            ['description' => 'Skype'],
            ['description' => 'Telefono'],
        ];

        DB::table('communication_types')->insert($communicationTypes);

    }
}
