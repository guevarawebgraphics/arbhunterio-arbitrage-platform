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

    private $total_counts = [
        'pre_match_count'   => 0,
        'live_count'    =>  0,
        'hidden_count'  =>  0
    ];

    public $page = 1;

    // protected $updatesQueryString = ['page'];

    public $is_live;

    protected $updatesQueryString = [
        'page' => ['except' => 1],
        'is_live',
        'is_hidden'
    ];

    public function mount()
    {
        $this->is_live = request()->query('is_live', 0);
        $this->is_hidden = request()->query('is_hidden', 0);

        $input = [];

        $input['is_live'] = $this->is_live;

        $input['is_hidden'] = $this->is_hidden;

        $this->games = $this->getGamesPerMarket($input);

        $this->total_counts = $this->getTotalCounts();
    }

    public function render()
    {
        $games = $this->games;

        $total_counts =  $this->total_counts;

        $pre_match_count = $total_counts['pre_match_count'];

        $live_count = $total_counts['live_count'];

        $hidden_count = $total_counts['hidden_count'];

        return view('livewire.games-table', ['games' => $games, 'pre_match_count'   =>  $pre_match_count, 'live_count'  =>  $live_count, 'hidden_count' =>  $hidden_count ]);
    }

    public function refreshTable()
    {
        $this->mount();

        $total_counts =  $this->total_counts;

        $pre_match_count = $total_counts['pre_match_count'];

        $live_count = $total_counts['live_count'];

        $hidden_count = $total_counts['hidden_count'];

        $this->emit('updateCounts', $pre_match_count, $live_count, $hidden_count);

        \Log::info( 'Data Table Refreshed: ' . date('H:i a',strtotime( now() )) );
    }
    
    public function updatedPage($value)
    {
        $this->is_live = request()->query('is_live', 0);

        $this->is_hidden = request()->query('is_hidden', 0);

        $input = [];

        $input['is_live'] = $this->is_live;

        $input['is_hidden'] = $this->is_hidden;

        $this->games = $this->getGamesPerMarket($input);
    }

    public function goToPage($page)
    {
        $this->is_live = request()->query('is_live', 0);
        $this->is_hidden = request()->query('is_hidden', 0);

        $input = [];

        $input['is_live'] = $this->is_live;
        $input['is_hidden'] = $this->is_hidden;

        $this->setPage($page);

        $this->games = $this->getGamesPerMarket($input);
    }

}
