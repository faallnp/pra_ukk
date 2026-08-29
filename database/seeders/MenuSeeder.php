<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create([
            'category_id' => 1,
            'name' => 'Gudeg Komplit',
            'description' => 'Gudeg dengan ayam, telur, dan krecek.',
            'price' => 25000,
            'image' => 'gudeg-komplit.jpg',
            'stock' => 20,
        ]);

        Menu::create([
            'category_id' => 1,
            'name' => 'Gudeg Ayam',
            'description' => 'Gudeg dengan ayam kampung.',
            'price' => 30000,
            'image' => 'gudeg-ayam.jpg',
            'stock' => 15,
        ]);

        Menu::create([
            'category_id' => 2,
            'name' => 'Es Teh',
            'description' => 'Es teh manis segar.',
            'price' => 5000,
            'image' => 'es-teh.jpg',
            'stock' => 50,
        ]);

        Menu::create([
            'category_id' => 3,
            'name' => 'Kerupuk',
            'description' => 'Kerupuk pendamping gudeg.',
            'price' => 3000,
            'image' => 'kerupuk.jpg',
            'stock' => 100,
        ]);
    }
}
