<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SystemSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('system_settings')->delete();
        
        \DB::table('system_settings')->insert(array (
            0 => 
            array (
                'code' => 'BJCDL_001', 
                'name' => 'Website Name',
                'type' => 'text',
                'value' => 'My CMS'
            ),
            1 => 
            array (
                'code' => 'BJCDL_002', 
                'name' => 'Website Description',
                'type' => 'text',
                'value' => 'Access Control List v2.1 crafted with Love'
            ),
            2 => 
            array (
                'code' => 'BJCDL_003', 
                'name' => 'Website Email',
                'type' => 'text',
                'value' => 'info@dev.com'
            ),
            3 => 
            array (
                'code' => 'BJCDL_004', 
                'name' => 'Website Address',
                'type' => 'textarea',
                'value' => 'Cavite, Philippines'
            ),
            4 => 
            array (
                'code' => 'BJCDL_005', 
                'name' => 'Default Meta Title',
                'type' => 'text',
                'value' => 'Default Meta Title'
            ),
            5 => 
            array (
                'code' => 'BJCDL_006', 
                'name' => 'Default Meta Keywords',
                'type' => 'textarea',
                'value' => 'Default Meta Keywords'
            ),
            6 => 
            array (
                'code' => 'BJCDL_007', 
                'name' => 'Default Meta Description',
                'type' => 'textarea',
                'value' => 'Default Meta Description'
            ),
            7 => 
            array (
                'code' => 'BJCDL_008', 
                'name' => 'Website Landline Number',
                'type' => 'text',
                'value' => '(000) 000-0000'
            ),
            8 => 
            array (
                'code' => 'BJCDL_009', 
                'name' => 'Website Email BCC',
                'type' => 'text',
                'value' => 'delaluya@gmail.com'
            ),
            9 => 
            array (
                'code' => 'BJCDL_010', 
                'name' => 'Registration Settings',
                'type' => 'toggle',
                'value' => '1'
            ),
            10 => 
            array (
                'code' => 'BJCDL_011', 
                'name' => 'Website Logo',
                'type' => 'file',
                'value' => 'public/images/my_cms_logo.png'
            ),
            11 => 
            array (
                'code' => 'BJCDL_012', 
                'name' => 'Website User Login',
                'type' => 'toggle',
                'value' => '1'
            ),
        ));
        
        
    }
}