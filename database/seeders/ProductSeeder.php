<?php

namespace Database\Seeders;

use App\Http\classes\FM;
use App\Http\classes\G;
use App\Models\File;
use App\Models\Person;
use App\Models\PersonInfo;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($c = 0; $c < 5; $c++) {
            $locationTarget = FM::location('/' . $c . '/', 'public');
            $result = FM::createFolder($locationTarget);

            $locationBase = FM::location("/sample-images/", 'public');

            $randomFirst = rand(1, 20) . ".png";
            $randomSecond =  rand(1, 20) . ".png";

            $newNameFirst =  Str::uuid() . ".png";
            $newNameSecond =  Str::uuid() . ".png";

            copy($locationBase . $randomFirst, $locationTarget . $newNameFirst);
            copy($locationBase . $randomSecond, $locationTarget . $newNameSecond);

            File::create([
                'orginal_name' =>  $randomFirst,
                'new_name' => $newNameFirst,
                'hash'=> null,
                'location' => ($locationTarget),
                'person_id' => 1,
                'type' => "public"
            ]);
            File::create([
                'orginal_name' =>  $randomSecond,
                'new_name' => $newNameSecond,
                'hash'=> null,
                'location' => ($locationTarget),
                'person_id' => 1,
                'type' => "public"
            ]);
            Product::create([
                'category_id' => 1,
                'name' => 'product ' . $c,
                'price' => rand(10000, 50000),
                'sale_price' => rand(50000, 100000),
                'status' => rand(0, 2),
                'stock' => 10,
                'image_folder' => '/' . $c . '/',
                'review' => 'nadarim',
                'description' => 'nadarim'
            ]);
        }
    }
}
