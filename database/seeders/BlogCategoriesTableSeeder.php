<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('blog_categories')->delete();
        
        \DB::table('blog_categories')->insert(array (
            0 => 
            array (
                'name' => 'General',
                'description' => 'General blogs... lorem ipsum dolor..'
            ),
            1 => 
            array (
                'name' => 'Technology',
                'description' => 'All about technology advancements... lorem ipsum dolor..'
            ),
            2 => 
            array (
                'name' => 'Uncategorized',
                'description' => 'Uncategorized blogs... lorem ipsum dolor..'
            ),
        ));
    }
}
