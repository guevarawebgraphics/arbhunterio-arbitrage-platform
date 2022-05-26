<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Super Admin',
                'guard_name' => 'web',
                'created_at' => '2021-06-08 00:00:00',
                'updated_at' => '2021-06-08 00:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Admin',
                'guard_name' => 'web',
                'created_at' => '2021-06-08 00:00:00',
                'updated_at' => '2021-06-08 00:00:00',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Normal',
                'guard_name' => 'web',
                'created_at' => '2021-06-08 00:00:00',
                'updated_at' => '2021-06-08 00:00:00',
            ),
        ));
        
        
    }
}