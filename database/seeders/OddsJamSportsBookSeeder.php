<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Http\Traits\OddsJamAPITrait;

class OddsJamSportsBookSeeder extends Seeder
{
    use OddsJamAPITrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sports_book = [
            '10bet',
            '888sport',
            'bet365',
            'BET99',
            'Betano',
            'Betcris',
            'BetDSI',
            'BetNow',
            'BetOnline',
            'BetonUSA',
            'Betsafe',
            'Betsson',
            'BetUS',
            'BetVictor',
            'Betway',
            'BookMaker',
            'bwin',
            'Casumo',
            'ComeOn!',
            'Coolbet',
            'Everygame',
            'Jazz Sports',
            'LeoVegas',
            'Looselines',
            'LowVig',
            'Mise-o-jeu',
            'MyBookie',
            'Nitrogen',
            'partypoker',
            'Pinnacle',
            'PowerPlay',
            'Royal Panda',
            'Sportsbetting.ag',
            'Sports Interaction',
            'Stake',
            'Suprabets',
            'TonyBet',
            'William Hill',
            'Xbet'
        ];


        \DB::table('sportsbooks')->delete();
        

        foreach ( $sports_book ?? [] as $book ) {
            \DB::table('sportsbooks')->insert(array (
                0 =>
                array (
                    'name' => $book,
                    'created_at' => '2021-01-01 00:00:00',
                    'updated_at' => '2021-01-01 00:00:00'
                ),
            ));
        }
        
    }
}
