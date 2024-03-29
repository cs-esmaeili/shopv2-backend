<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id =  Category::create([
            'name' => 'محصولات منتخب',
            'file_id' => 1,
            'parent_id' => 0,
        ]);
        $id =  Category::create([
            'name' => 'تخفیف خورده',
            'file_id' => 1,
            'parent_id' => 0,
        ]);
        $id =  Category::create([
            'name' => 'پر بازدید ترین',
            'file_id' => 1,
            'parent_id' => 0,
        ]);
        $id =  Category::create([
            'name' => 'فروش ویژه',
            'file_id' => 1,
            'parent_id' => 0,
        ]);
        $id =  Category::create([
            'name' => 'پر فروش ترین محصولات',
            'file_id' => 1,
            'parent_id' => 0,
        ]);
        for ($i = 0; $i < 10; $i++) {
            $id =  Category::create([
                'name' => $i,
                'file_id' => 1,
                'parent_id' => 0,
            ]);
            for ($b = 0; $b < 20; $b++) {
                $id1 = Category::create([
                    'name' => "sub " . $b . rand(0, 10),
                    'file_id' => 1,
                    'parent_id' => $id->category_id,
                ]);
                // for ($c = 0; $c < 2; $c++) {
                //     Category::create([
                //         'name' => "2 sub " . $c,
                //         'type' => "ماستی",
                //         'file_id' => 1,
                //         'parent_id' => $id1->category_id,
                //     ]);
                // }
            }
        }
    }
}
