<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Review;
//use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Book::factory(33)->create()->each(function ($book) {
            //number of reviews to create = at least 5 to 30
            $numReviews = random_int(5, 30); 

            //create sample good reviews for each created book 
            Review::factory()->count($numReviews)->good()->for($book)->create();
        
        });    

        Book::factory(33)->create()->each(function ($book) {
            //number of reviews to create = at least 5 to 30
            $numReviews = random_int(5, 30); 

            //create sample average reviews for each created book 
            Review::factory()->count($numReviews)->average()->for($book)->create();
        
        });   

        Book::factory(34)->create()->each(function ($book) {
            //number of sample reviews to create = at least 5 to 30
            $numReviews = random_int(5, 30); 

            //create sample bad reviews for each created book 
            Review::factory()->count($numReviews)->bad()->for($book)->create();
        
        });   
    }
}
