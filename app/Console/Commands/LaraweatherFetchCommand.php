<?php

namespace App\Console\Commands;

use App\Http\Resources\WeatherResource;
use App\Jobs\FetchWeatherJob;
use App\Models\City;
use Illuminate\Console\Command;

class LaraweatherFetchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laraweather:fetch {city?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch cities/city';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $city = $this->argument(key: 'city');
        if (empty($city)) {
            $cities = City::all();
            $cities->each(callback: function (City $city) {
               FetchWeatherJob::dispatch($city);
            });
        } else {
            WeatherResource::fetch(['city' => $city]);
        }
        return 0;
    }
}
