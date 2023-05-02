<?php

namespace Database\Seeders;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Meal;
use App\Models\Tag;
use App\Models\Translation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrasnlationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $t =array();
        foreach(Category::all()->unique('slug') as $key=>$value)
        {$slug =$value->slug;
            array_push($t,['slug'=>$slug,
            'eng_title'=>$slug,'hr_title'=>$slug.' (hr)', 
            'eng_description'=>$slug.' description',
            'hr_description'=>$slug.' opis']);
        }
        foreach(Tag::all()->unique('slug') as $key=>$value)
        {$slug =$value->slug;
            array_push($t,['slug'=>$slug,
            'eng_title'=>$slug,'hr_title'=>$slug.' (hr)', 
            'eng_description'=>$slug.' description',
            'hr_description'=>$slug.' opis']);
        }
        foreach(Ingredient::all()->unique('slug') as $key=>$value)
        {$slug =$value->slug;
            array_push($t,['slug'=>$slug,
            'eng_title'=>$slug,'hr_title'=>$slug.' (hr)', 
            'eng_description'=>$slug.' description',
            'hr_description'=>$slug.' opis']);
        }
        foreach(Meal::all()->unique('slug') as $key=>$value)
        {$slug =$value->slug;
            array_push($t,['slug'=>$slug,
            'eng_title'=>$slug,'hr_title'=>$slug.' (hr)', 
            'eng_description'=>$slug.' description',
            'hr_description'=>$slug.' opis']);
        }
        foreach($t as $key=>$value){
            Translation::create($value);
        }
    }
}
