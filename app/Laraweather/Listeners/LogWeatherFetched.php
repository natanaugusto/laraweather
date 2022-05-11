<?php

namespace App\Laraweather\Listeners;

use App\Laraweather\Events\FetchedFromWeatherAPI;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class LogWeatherFetched implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Laraweather\Events\FetchedFromWeatherAPI  $event
     * @return void
     */
    public function handle(FetchedFromWeatherAPI $event)
    {
        Log::info(message: 'Weather API Fetched', context: ['weather' => $event->weather]);
    }
}
