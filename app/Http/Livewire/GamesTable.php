<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\OddsJamAPITrait;

use DateTime;
use DateTimeZone;
use DateInterval;


class GamesTable extends Component
{
    use WithPagination, OddsJamAPITrait;

    protected $paginationTheme = 'tailwind'; // or 'tailwind', based on your preference

    public function render()
    {

        $games = $this->gamesPerMarketsV2([]);

        return view('livewire.games-table', ['games' => $games]);

    }
}
