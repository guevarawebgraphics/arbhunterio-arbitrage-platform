<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('menu')->delete();
        
        \DB::table('menu')->insert(array (
            0 => 
            array (
                'name' => 'Home',
                'is_page' => 1,
                'page_id' => 1,
                'link' => '',
                'open_in_new_tab' => 0,
                'order_number' => 1,
                'is_active' => 1
            ),
            1 => 
            array (
                'name' => 'About Us',
                'is_page' => 1,
                'page_id' => 2,
                'link' => '',
                'open_in_new_tab' => 0,
                'order_number' => 2,
                'is_active' => 1
            ),
            2 => 
            array (
                'name' => 'Contact Us',
                'is_page' => 1,
                'page_id' => 3,
                'link' => '',
                'open_in_new_tab' => 0,
                'order_number' => 3,
                'is_active' => 1
            ),
            3 => 
            array (
                'name' => 'Blogs',
                'is_page' => 1,
                'page_id' => 4,
                'link' => '',
                'open_in_new_tab' => 0,
                'order_number' => 4,
                'is_active' => 1
            ),
            4 => 
            array (
                'name' => 'Sample Pages',
                'is_page' => 0,
                'page_id' => 0,
                'link' => '#',
                'open_in_new_tab' => 0,
                'order_number' => 5,
                'is_active' => 1
            ),
        ));
    }
}
