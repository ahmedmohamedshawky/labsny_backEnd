<?php

use Illuminate\Database\Seeder;

class ColourCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('colour_categories')->delete();

        factory(\App\Models\ColourCategory::class,10)->create();
    }
}
