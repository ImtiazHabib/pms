<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Product::create([
             'name' => 'apple Watch',
             'price' => 150,
             'category_id' => '1',
             'description' => 'apple Watch is a brand new product of apple',
         ]);
    }
}
