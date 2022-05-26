<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ImageGalleryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('image_gallery')->delete();
        
        \DB::table('image_gallery')->insert(array (
            0 => 
            array (
                'gallery_group_id' => 2,
                'title' => 'First slide label',
                'content' => 'Some representative placeholder content for the first slide.',
                'background_image' => '/public/images/slide_img.png',
            ),
            1 => 
            array (
                'gallery_group_id' => 2,
                'title' => 'Second slide label',
                'content' => 'Some representative placeholder content for the second slide.',
                'background_image' => '/public/images/slide_img.png',
            ),
            2 => 
            array (
                'gallery_group_id' => 2,
                'title' => 'Third slide label',
                'content' => 'Some representative placeholder content for the third slide.',
                'background_image' => '/public/images/slide_img.png',
            ),
        ));
    }
}
