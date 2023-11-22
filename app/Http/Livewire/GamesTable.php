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

    protected $paginationTheme = 'tailwind'; // 'tailwind' or 'bootstrap'

    // protected $listeners = ['echo:odds-updates,NewOddsReceived' => 'refreshTable'];

    protected $listeners = ['refreshTable' => 'refreshTable'];

    private $games = [];

    private $total_counts = [
        'pre_match_count'   => 0,
        'live_count'    =>  0,
        'hidden_count'  =>  0
    ];

    public $page = 1;

    public $is_live;

    public $is_hidden;

    public $filter_param = [
        'min_profit'    =>   0,
        'max_profit'    =>   0,
        'sports'    =>   [],
        'sportsbook'    =>   [],
        'market'    =>   [],
        'date_time'    =>   0 // 0 = NONE; 1 = Today; 2 = Next 24 Hours
    ];

    protected $updatesQueryString = ['page' => ['except' => 1], 'is_live', 'is_hidden'];


    public function mount()
    {
        $this->is_live = request()->query('is_live', 0);

        $this->is_hidden = request()->query('is_hidden', 0);

        $input = [];

        $input['is_live'] = $this->is_live;

        $input['is_hidden'] = $this->is_hidden;

        $input['filter_param']  =  $this->filter_param;

        $this->games = $this->getGamesPerMarket($input);

        $this->total_counts = $this->getTotalCounts();

        $total_counts =  $this->total_counts;

        $this->emit('updateCounts', $total_counts['pre_match_count'], $total_counts['live_count'], $total_counts['hidden_count'] );
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

    public function refreshTable($data = [
            'min_profit'    =>   0,
            'max_profit'    =>   0,
            'sports'    =>   [],
            'sportsbook'    =>   [],
            'market'    =>   [],
            'date_time'    =>   0 // 0 = NONE; 1 = Today; 2 = Next 24 Hours
        ])
    {
        
        $this->filter_param = $data;

        $this->mount();

        \Log::info( 'Data Table Refreshed: ' . date('H:i a',strtotime( now() )) );
    }
    
    public function updatedPage($value)
    {
        $input = [];

        $input['is_live'] = $this->is_live;

        $input['is_hidden'] = $this->is_hidden;

        $input['filter_param']  =  $this->filter_param;
        
        $this->games = $this->getGamesPerMarket($input);
    }

    public function goToPage($page)
    {
        $this->setPage($page);

        $input = [];

        $input['is_live'] = $this->is_live;

        $input['is_hidden'] = $this->is_hidden;

        $input['filter_param']  =  $this->filter_param;

        $this->games = $this->getGamesPerMarket($input);
    }

}
