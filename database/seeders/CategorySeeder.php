<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::factory(5)->create();
        foreach ($categories as $category) {
            $category->factory(random_int(3, 6))->create([
                'parent_id' => $category->id,
            ]);
        }
    }
}
