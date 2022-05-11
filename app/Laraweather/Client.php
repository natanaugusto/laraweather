<?php

namespace App\Laraweather;

use App\Laraweather\Contracts\DriverInterface;
use App\Laraweather\Contracts\WeatherInterface;
use App\Laraweather\Events\FetchedFromWeatherAPIEvent;

class Client
{

    protected DriverInterface $driver;
    protected WeatherInterface $weather;

    public function __construct(DriverInterface $driver, WeatherInterface $weather)
    {
        $this->driver = $driver;
        $this->weather = $weather;
    }

    public function getByCity(string $name): WeatherInterface
    {
        $this->weather->setName(value: $name);
        $weather = $this->driver->toWeather(
            response: $this->driver->getFromAPI(
                q: $this->driver->toQuery($this->weather)
            ),
            weather: $this->weather
        );
        FetchedFromWeatherAPIEvent::dispatch($weather);
        return $weather;
    }
}
