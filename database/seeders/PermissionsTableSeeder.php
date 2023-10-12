<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Create Role',
                'guard_name' => 'web',
                'permission_group_id' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Read Role',
                'guard_name' => 'web',
                'permission_group_id' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Update Role',
                'guard_name' => 'web',
                'permission_group_id' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Delete Role',
                'guard_name' => 'web',
                'permission_group_id' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Restore Role',
                'guard_name' => 'web',
                'permission_group_id' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Create Permission',
                'guard_name' => 'web',
                'permission_group_id' => 2,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Read Permission',
                'guard_name' => 'web',
                'permission_group_id' => 2,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Update Permission',
                'guard_name' => 'web',
                'permission_group_id' => 2,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Delete Permission',
                'guard_name' => 'web',
                'permission_group_id' => 2,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            9 => 
            array (
                'id' => 11,
                'name' => 'Restore Permission',
                'guard_name' => 'web',
                'permission_group_id' => 2,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            10 => 
            array (
                'id' => 12,
                'name' => 'Create Permission Group',
                'guard_name' => 'web',
                'permission_group_id' => 3,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            11 => 
            array (
                'id' => 13,
                'name' => 'Read Permission Group',
                'guard_name' => 'web',
                'permission_group_id' => 3,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            12 => 
            array (
                'id' => 14,
                'name' => 'Update Permission Group',
                'guard_name' => 'web',
                'permission_group_id' => 3,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            13 => 
            array (
                'id' => 15,
                'name' => 'Delete Permission Group',
                'guard_name' => 'web',
                'permission_group_id' => 3,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            14 => 
            array (
                'id' => 16,
                'name' => 'Restore Permission Group',
                'guard_name' => 'web',
                'permission_group_id' => 3,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            15 => 
            array (
                'id' => 17,
                'name' => 'Create User',
                'guard_name' => 'web',
                'permission_group_id' => 4,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            16 => 
            array (
                'id' => 18,
                'name' => 'Read User',
                'guard_name' => 'web',
                'permission_group_id' => 4,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            17 => 
            array (
                'id' => 19,
                'name' => 'Update User',
                'guard_name' => 'web',
                'permission_group_id' => 4,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            18 => 
            array (
                'id' => 20,
                'name' => 'Delete User',
                'guard_name' => 'web',
                'permission_group_id' => 4,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            19 => 
            array (
                'id' => 21,
                'name' => 'Restore User',
                'guard_name' => 'web',
                'permission_group_id' => 4,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            20 => 
            array (
                'id' => 22,
                'name' => 'Create System Setting',
                'guard_name' => 'web',
                'permission_group_id' => 5,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            21 => 
            array (
                'id' => 23,
                'name' => 'Read System Setting',
                'guard_name' => 'web',
                'permission_group_id' => 5,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            22 => 
            array (
                'id' => 24,
                'name' => 'Update System Setting',
                'guard_name' => 'web',
                'permission_group_id' => 5,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            23 => 
            array (
                'id' => 25,
                'name' => 'Delete System Setting',
                'guard_name' => 'web',
                'permission_group_id' => 5,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            24 => 
            array (
                'id' => 26,
                'name' => 'Restore System Setting',
                'guard_name' => 'web',
                'permission_group_id' => 5,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            25 => 
            array (
                'id' => 27,
                'name' => 'Read Activity Log',
                'guard_name' => 'web',
                'permission_group_id' => 6,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            26 => 
            array (
                'id' => 28,
                'name' => 'Create Page',
                'guard_name' => 'web',
                'permission_group_id' => 7,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            27 => 
            array (
                'id' => 29,
                'name' => 'Read Page',
                'guard_name' => 'web',
                'permission_group_id' => 7,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            28 => 
            array (
                'id' => 30,
                'name' => 'Update Page',
                'guard_name' => 'web',
                'permission_group_id' => 7,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            29 => 
            array (
                'id' => 31,
                'name' => 'Delete Page',
                'guard_name' => 'web',
                'permission_group_id' => 7,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            30 => 
            array (
                'id' => 32,
                'name' => 'Restore Page',
                'guard_name' => 'web',
                'permission_group_id' => 7,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            31 => 
            array (
                'id' => 33,
                'name' => 'Create Gallery Group',
                'guard_name' => 'web',
                'permission_group_id' => 8,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            32 => 
            array (
                'id' => 34,
                'name' => 'Read Gallery Group',
                'guard_name' => 'web',
                'permission_group_id' => 8,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            33 => 
            array (
                'id' => 35,
                'name' => 'Update Gallery Group',
                'guard_name' => 'web',
                'permission_group_id' => 8,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            34 => 
            array (
                'id' => 36,
                'name' => 'Delete Gallery Group',
                'guard_name' => 'web',
                'permission_group_id' => 8,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            35 => 
            array (
                'id' => 37,
                'name' => 'Restore Gallery Group',
                'guard_name' => 'web',
                'permission_group_id' => 8,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            36 => 
            array (
                'id' => 38,
                'name' => 'Create Gallery Image',
                'guard_name' => 'web',
                'permission_group_id' => 9,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            37 => 
            array (
                'id' => 39,
                'name' => 'Read Gallery Image',
                'guard_name' => 'web',
                'permission_group_id' => 9,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            38 => 
            array (
                'id' => 40,
                'name' => 'Update Gallery Image',
                'guard_name' => 'web',
                'permission_group_id' => 9,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            39 => 
            array (
                'id' => 41,
                'name' => 'Delete Gallery Image',
                'guard_name' => 'web',
                'permission_group_id' => 9,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            40 => 
            array (
                'id' => 42,
                'name' => 'Restore Gallery Image',
                'guard_name' => 'web',
                'permission_group_id' => 9,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            41 => 
            array (
                'id' => 43,
                'name' => 'Create Blog Category',
                'guard_name' => 'web',
                'permission_group_id' => 10,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            42 => 
            array (
                'id' => 44,
                'name' => 'Read Blog Category',
                'guard_name' => 'web',
                'permission_group_id' => 10,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            43 => 
            array (
                'id' => 45,
                'name' => 'Update Blog Category',
                'guard_name' => 'web',
                'permission_group_id' => 10,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            44 => 
            array (
                'id' => 46,
                'name' => 'Delete Blog Category',
                'guard_name' => 'web',
                'permission_group_id' => 10,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            45 => 
            array (
                'id' => 47,
                'name' => 'Restore Blog Category',
                'guard_name' => 'web',
                'permission_group_id' => 10,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            46 => 
            array (
                'id' => 48,
                'name' => 'Create Blog',
                'guard_name' => 'web',
                'permission_group_id' => 11,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            47 => 
            array (
                'id' => 49,
                'name' => 'Read Blog',
                'guard_name' => 'web',
                'permission_group_id' => 11,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            48 => 
            array (
                'id' => 50,
                'name' => 'Update Blog',
                'guard_name' => 'web',
                'permission_group_id' => 11,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            49 => 
            array (
                'id' => 51,
                'name' => 'Delete Blog',
                'guard_name' => 'web',
                'permission_group_id' => 11,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            50 => 
            array (
                'id' => 52,
                'name' => 'Restore Blog',
                'guard_name' => 'web',
                'permission_group_id' => 11,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            51 => 
            array (
                'id' => 53,
                'name' => 'Read Contact',
                'guard_name' => 'web',
                'permission_group_id' => 12,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            52 => 
            array (
                'id' => 54,
                'name' => 'Read Newsletter',
                'guard_name' => 'web',
                'permission_group_id' => 13,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            53 => 
            array (
                'id' => 55,
                'name' => 'Create Menu',
                'guard_name' => 'web',
                'permission_group_id' => 14,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            54 => 
            array (
                'id' => 56,
                'name' => 'Read Menu',
                'guard_name' => 'web',
                'permission_group_id' => 14,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            55 => 
            array (
                'id' => 57,
                'name' => 'Update Menu',
                'guard_name' => 'web',
                'permission_group_id' => 14,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            56 => 
            array (
                'id' => 58,
                'name' => 'Delete Menu',
                'guard_name' => 'web',
                'permission_group_id' => 14,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            57 => 
            array (
                'id' => 59,
                'name' => 'Restore Menu',
                'guard_name' => 'web',
                'permission_group_id' => 14,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            58 => 
            array (
                'id' => 60,
                'name' => 'Create Menu Dropdown',
                'guard_name' => 'web',
                'permission_group_id' => 15,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            59 => 
            array (
                'id' => 61,
                'name' => 'Read Menu Dropdown',
                'guard_name' => 'web',
                'permission_group_id' => 15,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            60 => 
            array (
                'id' => 62,
                'name' => 'Update Menu Dropdown',
                'guard_name' => 'web',
                'permission_group_id' => 15,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            61 => 
            array (
                'id' => 63,
                'name' => 'Delete Menu Dropdown',
                'guard_name' => 'web',
                'permission_group_id' => 15,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            62 => 
            array (
                'id' => 64,
                'name' => 'Restore Menu Dropdown',
                'guard_name' => 'web',
                'permission_group_id' => 15,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            63 => 
            array (
                'id' => 65,
                'name' => 'Create Product Category',
                'guard_name' => 'web',
                'permission_group_id' => 16,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            64 => 
            array (
                'id' => 66,
                'name' => 'Read Product Category',
                'guard_name' => 'web',
                'permission_group_id' => 16,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            65 => 
            array (
                'id' => 67,
                'name' => 'Update Product Category',
                'guard_name' => 'web',
                'permission_group_id' => 16,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            66 => 
            array (
                'id' => 68,
                'name' => 'Delete Product Category',
                'guard_name' => 'web',
                'permission_group_id' => 16,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            67 => 
            array (
                'id' => 69,
                'name' => 'Restore Product Category',
                'guard_name' => 'web',
                'permission_group_id' => 16,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            68 => 
            array (
                'id' => 70,
                'name' => 'Create Product',
                'guard_name' => 'web',
                'permission_group_id' => 17,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            69 => 
            array (
                'id' => 71,
                'name' => 'Read Product',
                'guard_name' => 'web',
                'permission_group_id' => 17,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            70 => 
            array (
                'id' => 72,
                'name' => 'Update Product',
                'guard_name' => 'web',
                'permission_group_id' => 17,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            71 => 
            array (
                'id' => 73,
                'name' => 'Delete Product',
                'guard_name' => 'web',
                'permission_group_id' => 17,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            72 => 
            array (
                'id' => 74,
                'name' => 'Restore Product',
                'guard_name' => 'web',
                'permission_group_id' => 17,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            73 => 
            array (
                'id' => 75,
                'name' => 'Create Coupon Code',
                'guard_name' => 'web',
                'permission_group_id' => 18,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            74 => 
            array (
                'id' => 76,
                'name' => 'Read Coupon Code',
                'guard_name' => 'web',
                'permission_group_id' => 18,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            75 => 
            array (
                'id' => 77,
                'name' => 'Update Coupon Code',
                'guard_name' => 'web',
                'permission_group_id' => 18,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            76 => 
            array (
                'id' => 78,
                'name' => 'Delete Coupon Code',
                'guard_name' => 'web',
                'permission_group_id' => 18,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            77 => 
            array (
                'id' => 79,
                'name' => 'Restore Coupon Code',
                'guard_name' => 'web',
                'permission_group_id' => 18,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            78 => 
            array (
                'id' => 80,
                'name' => 'Create Tax',
                'guard_name' => 'web',
                'permission_group_id' => 19,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            79 => 
            array (
                'id' => 81,
                'name' => 'Read Tax',
                'guard_name' => 'web',
                'permission_group_id' => 19,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            80 => 
            array (
                'id' => 82,
                'name' => 'Update Tax',
                'guard_name' => 'web',
                'permission_group_id' => 19,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            81 => 
            array (
                'id' => 83,
                'name' => 'Delete Tax',
                'guard_name' => 'web',
                'permission_group_id' => 19,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
            82 => 
            array (
                'id' => 84,
                'name' => 'Restore Tax',
                'guard_name' => 'web',
                'permission_group_id' => 19,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ),
        ));
        
        
    }
}