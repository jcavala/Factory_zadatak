<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Tag;
use App\Models\Meal;
use Illuminate\Database\Seeder;
use Database\Seeders\TrasnlationSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        Meal::factory()->count(3)->hasCategories(3)
        ->hasIngredients(3)->hasTags(3)->create();
       // ->has(Ingredient::factory()->count(5),'ingredients')
        //->has(Tag::factory()->count(5))->count(3)->create();
        $this->call(TrasnlationSeeder::class);

    }
}
