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

    public $page = 1;

    protected $updatesQueryString = ['page'];

    public function mount()
    {
        $this->games = $this->gamesPerMarketsV3([]);
    }

    public function render()
    {
        $games = $this->games;

        return view('livewire.games-table', ['games' => $games]);
    }

    public function refreshTable()
    {
        // This will refresh the data by re-fetching from the database.
        $this->mount();
        \Log::info('Data Table Refreshed: ' . date('H:i a',strtotime( now() )) );
    }
    
    public function updatedPage($value)
    {
        $this->games = $this->gamesPerMarketsV3([]);
    }

    public function goToPage($page)
    {
        $this->setPage($page);
        $this->games = $this->gamesPerMarketsV3([]);
    }

}
