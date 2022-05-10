<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use Illuminate\Support\Facades\Http;

uses(Tests\TestCase::class)->in('Feature', 'Laraweather');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/
function mockHttp(mixed $body): void
{
    Http::fake(callback: function () use ($body) {
        return Http::response(
            body: $body,
            status: \Symfony\Component\HttpFoundation\Response::HTTP_OK
        );
    });
}

function providers(): void
{
    app()->bind(abstract: \App\Laraweather\Contracts\WeatherInterface::class, concrete: function () {
        return new \App\Laraweather\Weather();
    });

    app()->singleton(abstract: \App\Laraweather\Contracts\DriverInterface::class, concrete: function () {
        return new \App\Laraweather\Drivers\TestDriver();
    });

    app()->singleton(abstract: \App\Laraweather\Facades\Weather::BINDING_NAME, concrete: function ($app) {
        return $app->make(\App\Laraweather\Client::class);
    });
}
