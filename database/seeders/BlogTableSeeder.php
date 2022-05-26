<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('blogs')->delete();
        
        \DB::table('blogs')->insert(array (
            0 => 
            array (
                'blog_category_id' => 1,
                'slug' => 'blog-post-title',
                'title' => 'Blog post title',
                'author' => 'Juan Dela Cruz',
                'content' => 'Some quick example text to build on the card title and make up the bulk of the card\'s content.',
                'thumbnail' => '/public/images/blog_img.png',
                'cover_image' => '/public/images/blog_img.png',
                'seo_meta_id' => 8,
                'is_featured' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00'
            ),
            1 => 
            array (
                'blog_category_id' => 2,
                'slug' => 'another-blog-post-title',
                'title' => 'Another blog post title',
                'author' => 'John Doe',
                'content' => 'This text is a bit longer to illustrate the adaptive height of each card. Some quick example text to build on the card title and make up the bulk of the card\'s content.',
                'thumbnail' => '/public/images/blog_img2.png',
                'cover_image' => '/public/images/blog_img2.png',
                'seo_meta_id' => 9,
                'is_featured' => 0,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00'
            ),
            2 => 
            array (
                'blog_category_id' => 3,
                'slug' => 'the-last-blog-post-title-is-a-little-bit-longer-than-the-others',
                'title' => 'The last blog post title is a little bit longer than the others',
                'author' => 'System Admin',
                'content' => 'Some more quick example text to build on the card title and make up the bulk of the card\'s content.',
                'thumbnail' => '/public/images/blog_img3.png',
                'cover_image' => '/public/images/blog_img3.png',
                'seo_meta_id' => 10,
                'is_featured' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00'
            ),
        ));
    }
}
