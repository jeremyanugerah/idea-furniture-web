<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cartitems')->insert([
            ['user_id'=>2, 'product_id'=>1, 'quantity'=>3],
            ['user_id'=>2, 'product_id'=>2, 'quantity'=>4],
            ['user_id'=>2, 'product_id'=>3, 'quantity'=>2],
            ['user_id'=>2, 'product_id'=>4, 'quantity'=>5],
        ]);
    }
}
