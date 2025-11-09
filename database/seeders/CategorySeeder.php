<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
        [
            'name'=>[
                'ar'=>'الاول',
                'en'=> 'first',
            ],
            'status'=>1,
            'parent'=>null
        ],
        [
            'name'=>[
                'ar'=>'التاني',
                'en'=> 'second',
            ],
            'status'=>1,
            'parent'=>null
        ],
        [
            'name'=>[
                'ar'=>'التالت',
                'en'=> 'third',
            ],
            'status'=>0,
            'parent'=>null
        ],
        [
            'name'=>[
                'ar'=>'1الاول',
                'en'=> 'first1',
            ],
            'status'=>1,
            'parent'=>1
        ],
    ];
    foreach ($data as $cat) {
        Category::create($cat);
    }
    }
}
