<?php
use App\Laraweather\Events\FetchedFromWeatherAPIEvent;
use App\Laraweather\Listeners\LogWeatherFetchedListeners;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;

test(description: 'Artisan laraweather:fetch command', closure: function ($weatherBody) {
    mockHttp($weatherBody);
    provider();
    Queue::fake();
    Event::fake();
    Event::listen(
        events: FetchedFromWeatherAPIEvent::class,
        listener: LogWeatherFetchedListeners::class
    );
    \App\Models\City::factory(count: 5)->create();
    $this->artisan(command: 'laraweather:fetch')
        ->assertSuccessful();
    Queue::assertPushed(job: \App\Jobs\FetchWeatherJob::class);
    Event::assertListening(
        expectedEvent: FetchedFromWeatherAPIEvent::class,
        expectedListener: LogWeatherFetchedListeners::class
    );
})->with(data: 'weatherapi/openweatherapi/weather');
