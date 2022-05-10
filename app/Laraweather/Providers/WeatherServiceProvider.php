<?php

namespace App\Laraweather\Providers;

use Illuminate\Support\ServiceProvider;

class WeatherServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(abstract: \App\Laraweather\Contracts\WeatherInterface::class, concrete: function () {
            return new \App\Laraweather\Weather();
        });

        $this->app->singleton(abstract: \App\Laraweather\Contracts\DriverInterface::class, concrete: function () {
            return new \App\Laraweather\Drivers\OpenWeatherMapDriver();
        });

        $this->app->singleton(abstract: \App\Laraweather\Facades\Weather::BINDING_NAME, concrete: function ($app) {
            return $app->make(\App\Laraweather\Client::class);
        });
    }

    public function boot(): void
    {

    }
}
