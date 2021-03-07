<?php

use Illuminate\Database\Seeder;

class ClothesReviewsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('clothes_reviews')->delete();

        factory(\App\Models\ClothesReview::class,30)->create();
        
        
    }
}