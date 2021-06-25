<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_types')->insert([
            ['name'=>'Children Toys', 'image'=> '/storage/images/ProductTypes001.jpg'],
            ['name'=>'Christmas Decor', 'image'=> '/storage/images/ProductTypes002.jpg'],
            ['name'=>'Home Desks', 'image'=> '/storage/images/ProductTypes003.jpg'],
            ['name'=>'Bookshelves', 'image'=> '/storage/images/ProductTypes004.jpg'],
            ['name'=>'Bed Frames', 'image'=> '/storage/images/ProductTypes005.jpg'],
            ['name'=>'Chest & Drawers', 'image'=> '/storage/images/ProductTypes006.jpg'],
            ['name'=>'Wardrobes', 'image'=> '/storage/images/ProductTypes007.jpg'],
            ['name'=>'Bedlinens', 'image'=> '/storage/images/ProductTypes008.jpg'],
            ['name'=>'Sofas', 'image'=> '/storage/images/ProductTypes009.jpg'],
            ['name'=>'Chairs', 'image'=> '/storage/images/ProductTypes010.jpg'],
        ]);
    }
}