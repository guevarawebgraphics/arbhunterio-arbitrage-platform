<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Traits\OddsJamAPITrait;
use Illuminate\Support\Facades\File;

class StoreOddsStreamJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, OddsJamAPITrait;

    protected $jsonData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($jsonData)
    {
        $this->jsonData = $jsonData;
    }
    /**
     * Execute the job.
     * 
     * @return void
     *  
    */
    public function handle()
    {
        $filePath = public_path('odds.json');

        $raw_query = json_decode($this->jsonData);

        // Merge entry_id and type into each bet item
        foreach ($raw_query->data as $bet) {
            $bet->entry_id = $raw_query->entry_id;
            $bet->type = $raw_query->type;
        }

        $existingData = [];
        
        // If the file is not empty, read the existing content
        if (File::size($filePath) > 0) {
            $existingData = json_decode(File::get($filePath));
        }

        // Merge existing data with new data
        $updatedData = array_merge($existingData, $raw_query->data);

        // Convert the updated data to a JSON string
        $jsonData = json_encode($updatedData, JSON_PRETTY_PRINT);

        // Write the updated content back to the file
        File::put($filePath, $jsonData);
    }
}
