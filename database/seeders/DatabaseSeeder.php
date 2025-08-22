<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $food = Category::create(['name' => 'Makanan']);
        // $drink = Category::create(['name' => 'Minuman']);

        // Product::create([
        //     'name' => 'Nasi Goreng',
        //     'category_id' => $food->id,
        //     'price' => 20000,
        //     'stock' => 10,
        // ]);

        // Product::create([
        //     'name' => 'Es Teh Manis',
        //     'category_id' => $drink->id,
        //     'price' => 5000,
        //     'stock' => 50,
        // ]);

        $this->call(AdminSeeder::class);
    }

}
