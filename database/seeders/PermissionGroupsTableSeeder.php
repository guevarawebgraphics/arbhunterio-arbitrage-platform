<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class PermissionGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permission_groups')->delete();
        
        \DB::table('permission_groups')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Roles',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Permissions',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Permission Groups',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Users',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'System Settings',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Activity Logs',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 7,
                'name' => 'Pages',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 8,
                'name' => 'Gallery Groups',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 9,
                'name' => 'Gallery Images',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 10,
                'name' => 'Blog Categories',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 11,
                'name' => 'Blogs',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 12,
                'name' => 'Contacts',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 13,
                'name' => 'Newsletter Subscribers',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 14,
                'name' => 'Menu',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 15,
                'name' => 'Menu Dropdown',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 16,
                'name' => 'Product Category',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 17,
                'name' => 'Product',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 18,
                'name' => 'Coupon Code',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            array (
                'id' => 19,
                'name' => 'Taxes',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}