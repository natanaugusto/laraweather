<?php

namespace App\Laraweather\Listeners;

use App\Laraweather\Events\FetchedFromWeatherAPIEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class LogWeatherFetchedListeners implements ShouldQueue
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
     * @param  \App\Laraweather\Events\FetchedFromWeatherAPIEvent  $event
     * @return void
     */
    public function handle(FetchedFromWeatherAPIEvent $event)
    {
        Log::info(message: 'Weather API Fetched', context: ['weather' => $event->weather]);
    }
}
