<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Services\Users\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
  
class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('users')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'first_name' => 'I am', 
                    'middle_name' => '', 
                    'last_name' => 'Super Admin', 
                    'email' => 'superadmin@dev.io',
                    'user_name' => 'superadmin',
                    'password' => bcrypt('superadmin'),
                    'created_at' => '2021-01-01 00:00:00',
                    'updated_at' => '2021-01-01 00:00:00'
                ),
            1 =>
                array (
                    'id' => 2,
                    'first_name' => 'I am', 
                    'middle_name' => '', 
                    'last_name' => 'Admin', 
                    'email' => 'admin@dev.io',
                    'user_name' => 'admin',
                    'password' => bcrypt('admin'),
                    'created_at' => '2021-01-01 00:00:00',
                    'updated_at' => '2021-01-01 00:00:00'
                ),
                2 =>
                array (
                    'id' => 3,
                    'first_name' => 'I am', 
                    'middle_name' => '', 
                    'last_name' => 'Test user', 
                    'email' => 'test@dev.io',
                    'user_name' => 'test',
                    'password' => bcrypt('test'),
                    'created_at' => '2021-01-01 00:00:00',
                    'updated_at' => '2021-01-01 00:00:00'
                ),
            3 =>
                array (
                    'id' => 4,
                    'first_name' => 'I am', 
                    'middle_name' => '', 
                    'last_name' => 'New Test', 
                    'email' => 'test@gmail.com',
                    'user_name' => 'test123',
                    'password' => bcrypt('test123'),
                    'created_at' => '2021-01-01 00:00:00',
                    'updated_at' => '2021-01-01 00:00:00'
                ),
        ));
    }
}