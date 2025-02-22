<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Random\RandomException;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws RandomException
     */
    public function run(): void
    {
        Category::factory(6)->create()->each(function ($category) {
            $numSubCategory = random_int(3, 5);
            Category::factory($numSubCategory)->create([
                'parent_id' => $category->id
            ]);
        });
    }
}
