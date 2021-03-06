<?php

use Illuminate\Database\Seeder;

class FoodOrdersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('food_orders')->delete();
        
        \DB::table('food_orders')->insert(array (
            0 => 
            array (
                'id' => 1,
                'price' => 11.0,
                'quantity' => 1,
                'food_id' => 1,
                'order_id' => 1,
                'created_at' => '2020-03-29 17:38:45',
                'updated_at' => '2020-03-29 17:38:45',
            ),
            1 => 
            array (
                'id' => 2,
                'price' => 7.4,
                'quantity' => 3,
                'food_id' => 2,
                'order_id' => 2,
                'created_at' => '2020-03-29 17:50:26',
                'updated_at' => '2020-03-29 17:50:26',
            ),
            2 => 
            array (
                'id' => 3,
                'price' => 7.99,
                'quantity' => 1,
                'food_id' => 4,
                'order_id' => 2,
                'created_at' => '2020-03-29 17:50:26',
                'updated_at' => '2020-03-29 17:50:26',
            ),
            3 => 
            array (
                'id' => 4,
                'price' => 7.4,
                'quantity' => 3,
                'food_id' => 4,
                'order_id' => 3,
                'created_at' => '2020-03-29 17:52:16',
                'updated_at' => '2020-03-29 17:52:16',
            ),
        ));
        
        
    }
}