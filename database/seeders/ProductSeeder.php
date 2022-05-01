<?php

namespace Database\Seeders;

use App\Http\classes\G;
use App\Models\File;
use App\Models\Person;
use App\Models\PersonInfo;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($c = 0; $c < 80; $c++) {
            Product::create([
                'category_id' => 1,
                'name' => 'product ' . $c,
                'price' => rand(10000, 50000),
                'sale_price' => rand(50000, 100000),
                'status' => rand(0, 2),
                'stock' => 10,
                'image_folder' => '/Admins/name-family/',
                'review' => 'nadarim',
                'description' => 'nadarim'
            ]);
        }
    }
}
