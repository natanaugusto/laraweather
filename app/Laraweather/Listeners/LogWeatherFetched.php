<?php

namespace App\Laraweather\Listeners;

use App\Laraweather\Events\FetchedFromWeatherAPI;

class LogWeatherFetched
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
        //
    }
}
