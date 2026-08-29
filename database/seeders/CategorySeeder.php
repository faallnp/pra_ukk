<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            ['name' => 'Gudeg'],
            ['name' => 'Minuman'],
            ['name' => 'Snack'],
        ]);
    }
}
