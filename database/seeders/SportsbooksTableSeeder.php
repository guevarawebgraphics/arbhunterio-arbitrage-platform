<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SportsbooksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sportsbooks')->delete();
        
        \DB::table('sportsbooks')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '10bet',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '888sport',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'bet365',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'BET99',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Betano',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Betcris',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'BetDSI',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'BetNow',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'BetOnline',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'BetonUSA',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Betsafe',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Betsson',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'BetUS',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'BetVictor',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Betway',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'BookMaker',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'bwin',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Casumo',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'ComeOn!',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Coolbet',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Everygame',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Jazz Sports',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'LeoVegas',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Looselines',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'LowVig',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Mise-o-jeu',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'MyBookie',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Nitrogen',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'partypoker',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Pinnacle',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'PowerPlay',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Royal Panda',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Sportsbetting.ag',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'Sports Interaction',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Stake',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Suprabets',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'TonyBet',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'William Hill',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'Xbet',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}