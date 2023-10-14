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
                'image_url' => 'public/images/sports_book_name/10bet.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '888sport',
                'image_url' => 'public/images/sports_book_name/888sport.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'bet365',
                'image_url' => 'public/images/sports_book_name/bet365.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'BET99',
                'image_url' => 'public/images/sports_book_name/bet99.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Betano',
                'image_url' => 'public/images/sports_book_name/betano.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Betcris',
                'image_url' => 'public/images/sports_book_name/betcris.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'BetDSI',
                'image_url' => 'public/images/sports_book_name/betdsi.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'BetNow',
                'image_url' => 'public/images/sports_book_name/betnow.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'BetOnline',
                'image_url' => 'public/images/sports_book_name/betonline.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'BetonUSA',
                'image_url' => 'public/images/sports_book_name/betonusa.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Betsafe',
                'image_url' => 'public/images/sports_book_name/betsafe.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Betsson',
                'image_url' => 'public/images/sports_book_name/betsson.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'BetUS',
                'image_url' => 'public/images/sports_book_name/betus.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'BetVictor',
                'image_url' => 'public/images/sports_book_name/betvictor.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Betway',
                'image_url' => 'public/images/sports_book_name/betway.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'BookMaker',
                'image_url' => 'public/images/sports_book_name/bookmaker.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'bwin',
                'image_url' => 'public/images/sports_book_name/bwin.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Casumo',
                'image_url' => 'public/images/sports_book_name/casumo.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'ComeOn!',
                'image_url' => 'public/images/sports_book_name/comeon.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Coolbet',
                'image_url' => 'public/images/sports_book_name/coolbet.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Everygame',
                'image_url' => 'public/images/sports_book_name/everygame.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Jazz Sports',
                'image_url' => 'public/images/sports_book_name/jazzsports.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'LeoVegas',
                'image_url' => 'public/images/sports_book_name/leovegas.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Looselines',
                'image_url' => 'public/images/sports_book_name/looselines.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'LowVig',
                'image_url' => 'public/images/sports_book_name/lowvig.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Mise-o-jeu',
                'image_url' => 'public/images/sports_book_name/miseojeu.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'MyBookie',
                'image_url' => 'public/images/sports_book_name/mybookie.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Nitrogen',
                'image_url' => 'public/images/sports_book_name/nitrogen.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'partypoker',
                'image_url' => 'public/images/sports_book_name/partypoker.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Pinnacle',
                'image_url' => 'public/images/sports_book_name/pinnacle.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'PowerPlay',
                'image_url' => 'public/images/sports_book_name/powerplay.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Royal Panda',
                'image_url' => 'public/images/sports_book_name/royalpanda.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Sportsbetting.ag',
                'image_url' => 'public/images/sports_book_name/sportsbetting.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'Sports Interaction',
                'image_url' => 'public/images/sports_book_name/sportsinteraction.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Stake',
                'image_url' => 'public/images/sports_book_name/stake.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Suprabets',
                'image_url' => 'public/images/sports_book_name/suprabets.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'TonyBet',
                'image_url' => 'public/images/sports_book_name/tonybet.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'William Hill',
                'image_url' => 'public/images/sports_book_name/williamhill.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'Xbet',
                'image_url' => 'public/images/sports_book_name/xbet.webp',
                'is_active' => 1,
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}