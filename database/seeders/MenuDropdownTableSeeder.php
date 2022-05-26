<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MenuDropdownTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('menu_dropdown')->delete();
        
        \DB::table('menu_dropdown')->insert(array (
            0 => 
            array (
                'menu_id' => 5,
                'name' => 'Default Page',
                'is_page' => 0,
                'page_id' => 0,
                'link' => 'default-page',
                'open_in_new_tab' => 0,
                'order_number' => 1,
                'is_active' => 1
            ),
            1 => 
            array (
                'menu_id' => 5,
                'name' => '404 Page',
                'is_page' => 0,
                'page_id' => 0,
                'link' => 'BJCDL404',
                'open_in_new_tab' => 0,
                'order_number' => 2,
                'is_active' => 1
            ),
        ));
    }
}
