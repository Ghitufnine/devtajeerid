<?php

use Illuminate\Database\Seeder;

class FoodsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('foods')->delete();
        
        \DB::table('foods')->insert([
            [
                'id' => 1,
                'name' => 'Pecel Mbok Galak',
                'price' => 8000,
                'discount_price' => 0.00,
                'weight' => 0.00,
                'featured' => 1,
                'restaurant_id' => 1,
                'category_id' => 1
            ],
            [
                'id' => 2,
                'name' => 'Gado-gado Warok',
                'price' => 8500,
                'discount_price' => 0.00,
                'weight' => 0.00,
                'featured' => 1,
                'restaurant_id' => 2,
                'category_id' => 1
            ],
            [
                'id' => 3,
                'name' => 'Indomie Larang',
                'price' => 20000,
                'discount_price' => 0.00,
                'weight' => 0.00,
                'featured' => 1,
                'restaurant_id' => 3,
                'category_id' => 1
            ],
            [
                'id' => 4,
                'name' => 'Gorengan Larang',
                'price' => 15000,
                'discount_price' => 0.00,
                'weight' => 0.00,
                'featured' => 1,
                'restaurant_id' => 4,
                'category_id' => 1
            ]
        ]);
        
        
    }
}