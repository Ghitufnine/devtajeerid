<?php

use Illuminate\Database\Seeder;

class ShopCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('shop_categories')->delete();

        \DB::table('shop_categories')->insert( array(
            0 =>
            array (
                'id' => 1,
                'name' => 'Grosir'
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Eceran'
            )
            ));
    }
}
