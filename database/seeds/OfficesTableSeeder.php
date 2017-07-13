<?php

use Illuminate\Database\Seeder;

class OfficesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $offices = [
            ['description' => 'Amministrazione'],
            ['description' => 'Ufficio tecnico'],
        ];

        DB::table('offices')->insert($offices);
    }
}
