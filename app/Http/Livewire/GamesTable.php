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

    protected $paginationTheme = 'tailwind'; // 'tailwind' or 'bootstrap', based on your preference

    protected $listeners = ['echo:odds-updates,NewOddsReceived' => 'refreshTable'];

    private $games = [];

    public function mount()
    {
        $this->games = $this->gamesPerMarketsV3([]);
    }

    public function render()
    {
        // $games = $this->gamesPerMarketsV3([]);
        $games = $this->games;

        // Since the dataset is paginated, get the items for sorting.
        $sortedItems = $games->getCollection()->sortByDesc(function($game) {
            $data = getOdds($game);
            return ($data['best_odds_a'] * $data['best_odds_b']) > 0 ? $data['profit_percentage'] : 0;
        })->values();

        // Set the sorted items back on the paginator instance.
        $games->setCollection($sortedItems);

        return view('livewire.games-table', ['games' => $games]);
    }

    public function refreshTable()
    {
        // This will refresh the data by re-fetching from the database.
        $this->mount();
        \Log::info('Data Table Refreshed: ' . date('H:i a',strtotime( now() )) );
    }


}
