<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SeoMetasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('seo_metas')->delete();
        
        \DB::table('seo_metas')->insert(array (
            0 => 
            array (
                'id' => 1,
                'meta_title' => 'Home - My CMS V2.1',
                'meta_keywords' => 'Home',
                'meta_description' => 'Home',
                'canonical_link' => '',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'meta_title' => 'About Us',
                'meta_keywords' => 'About Us',
                'meta_description' => 'About Us',
                'canonical_link' => '',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'meta_title' => 'Contact Us',
                'meta_keywords' => 'Contact Us',
                'meta_description' => 'Contact Us',
                'canonical_link' => '',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'meta_title' => 'Blogs',
                'meta_keywords' => 'Blogs',
                'meta_description' => 'Blogs',
                'canonical_link' => '',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'meta_title' => 'Default Page',
                'meta_keywords' => 'Default Page',
                'meta_description' => 'Default Page',
                'canonical_link' => '',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'meta_title' => 'Privacy',
                'meta_keywords' => 'Privacy',
                'meta_description' => 'Privacy',
                'canonical_link' => '',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'meta_title' => 'Terms',
                'meta_keywords' => 'Terms',
                'meta_description' => 'Terms',
                'canonical_link' => '',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'meta_title' => 'Blog Post Title',
                'meta_keywords' => 'Blog Post Title',
                'meta_description' => 'Blog Post Title',
                'canonical_link' => '',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'meta_title' => 'Another blog post title',
                'meta_keywords' => 'Another blog post title',
                'meta_description' => 'Another blog post title',
                'canonical_link' => '',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'meta_title' => 'The last blog post title is a little bit longer than the others',
                'meta_keywords' => 'The last blog post title is a little bit longer than the others',
                'meta_description' => 'The last blog post title is a little bit longer than the others',
                'canonical_link' => '',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'meta_title' => 'Customer Login',
                'meta_keywords' => 'Customer Login',
                'meta_description' => 'Customer Login',
                'canonical_link' => '',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'meta_title' => 'Customer Register',
                'meta_keywords' => 'Customer Register',
                'meta_description' => 'Customer Register',
                'canonical_link' => '',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'meta_title' => 'Customer Forgot Password',
                'meta_keywords' => 'Customer Forgot Password',
                'meta_description' => 'Customer Forgot Password',
                'canonical_link' => '',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'meta_title' => 'Customer Dashboard',
                'meta_keywords' => 'Customer Dashboard',
                'meta_description' => 'Customer Dashboard',
                'canonical_link' => '',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'meta_title' => 'Customer Orders',
                'meta_keywords' => 'Customer Orders',
                'meta_description' => 'Customer Orders',
                'canonical_link' => '',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'meta_title' => 'Customer Address',
                'meta_keywords' => 'Customer Address',
                'meta_description' => 'Customer Address',
                'canonical_link' => '',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'meta_title' => 'Customer Account Details',
                'meta_keywords' => 'Customer Account Details',
                'meta_description' => 'Customer Account Details',
                'canonical_link' => '',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
        ));
    }
}
