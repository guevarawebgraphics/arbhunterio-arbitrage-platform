<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GalleryGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('gallery_group')->delete();
        
        \DB::table('gallery_group')->insert(array (
            0 => 
            array (
                'name' => 'General',
                'description' => 'General photos... lorem ipsum dolor..'
            ),
            1 => 
            array (
                'name' => 'Home Sliders',
                'description' => 'Picture for Home Slider'
            ),
            2 => 
            array (
                'name' => 'Random',
                'description' => 'Random photos... lorem ipsum dolor..'
            ),
        ));
    }
}
