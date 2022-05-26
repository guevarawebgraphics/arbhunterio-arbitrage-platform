<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CouponCodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('coupon_codes')->delete();
        
        \DB::table('coupon_codes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Test Coupon Perc',
                'user_id' => 1,
                'code' => 'TEST_COUPON_PERCENTAGE',
                'value' => '10.00',
                'type' => 1,
                'times_of_use' => 0,
                'used' => 0,
                'once_per_customer' => 0,
                'apply_category' => '',
                'apply_product' => '',
                'is_no_time_limit' => 0,
                'date_start' => '2021-01-01 00:00:00',
                'date_end' => '2021-01-01 00:00:00',
                'created_at' => '2021-01-01 16:54:37',
                'updated_at' => '2021-01-01 16:54:37',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Test Coupon Amount',
                'user_id' => 1,
                'code' => 'TEST_COUPON_AMOUNT',
                'value' => '50.00',
                'type' => 2,
                'times_of_use' => 0,
                'used' => 0,
                'once_per_customer' => 0,
                'apply_category' => '',
                'apply_product' => '',
                'is_no_time_limit' => 0,
                'date_start' => '2021-01-01 00:00:00',
                'date_end' => '2021-01-01 00:00:00',
                'created_at' => '2021-01-01 16:57:37',
                'updated_at' => '2021-01-01 16:57:37',
                'deleted_at' => NULL,
            ),
        ));
    }
}
