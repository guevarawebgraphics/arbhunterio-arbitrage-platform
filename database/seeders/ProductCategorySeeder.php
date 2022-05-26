<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('product_category')->delete();
        
        \DB::table('product_category')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Test',
                'created_at' => '2021-01-01 11:07:12',
                'updated_at' => '2021-01-01 11:07:12',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Another Test Category',
                'created_at' => '2021-01-01 11:07:12',
                'updated_at' => '2021-01-01 11:07:12',
                'deleted_at' => NULL,
            ),
        ));
    }
}
