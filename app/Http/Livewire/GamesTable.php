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

    // Removed due to it automatically refreshes frontend. This can be triggered through client side
    // protected $listeners = ['echo:odds-updates,NewOddsReceived' => 'refreshTable'];

    // This tends to receive request of echo from client side.
    protected $listeners = ['refreshTable' => 'refreshTable'];

    private $games = [];

    public $page = 1;

    // protected $updatesQueryString = ['page'];

    public $is_live;

    protected $updatesQueryString = [
        'page' => ['except' => 1],
        'is_live'
    ];

    public function mount()
    {
        $this->is_live = request()->query('is_live', 0);

        $input = [];
        $input['is_live'] = $this->is_live;
        $this->games = $this->getGamesPerMarket($input);
    }

    public function render()
    {
        $games = $this->games;

        return view('livewire.games-table', ['games' => $games]);
    }

    public function refreshTable()
    {
        $this->mount();
        
        \Log::info( 'Data Table Refreshed: ' . date('H:i a',strtotime( now() )) );
    }
    
    public function updatedPage($value)
    {
        $this->is_live = request()->query('is_live', 0);

        $input = [];

        $input['is_live'] = $this->is_live;

        $this->games = $this->getGamesPerMarket($input);
    }

    public function goToPage($page)
    {
        $this->is_live = request()->query('is_live', 0);

        $input = [];

        $input['is_live'] = $this->is_live;

        $this->setPage($page);

        $this->games = $this->getGamesPerMarket($input);
    }

}
