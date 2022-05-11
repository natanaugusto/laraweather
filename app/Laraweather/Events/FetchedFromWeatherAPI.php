<?php

namespace App\Laraweather\Events;

use App\Laraweather\Contracts\WeatherInterface;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class FetchedFromWeatherAPI
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public WeatherInterface $weather;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(WeatherInterface $weather)
    {
        $this->weather = $weather;
    }
}
