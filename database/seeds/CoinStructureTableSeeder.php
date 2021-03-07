<?php

use Illuminate\Database\Seeder;

class CoinStructureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('coin_structures')->delete();

        factory(\App\Models\CoinStructure::class, 1)->create();
    }
}
