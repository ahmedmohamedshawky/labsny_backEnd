<?php

use Illuminate\Database\Seeder;

class ClothesColourCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('clothes_colour_categories')->delete();

        factory(\App\Models\ClothesColourCategory::class,10)->create();
    }
}
