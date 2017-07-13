<?php

use Illuminate\Database\Seeder;

class TitlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $titles = [
            ['description' => 'Spett.le'],
            ['description' => 'Sig.'],
            ['description' => 'Sig.ra'],
        ];

        DB::table('titles')->insert($titles);
    }
}
