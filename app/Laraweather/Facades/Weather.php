<?php

namespace App\Laraweather\Facades;

use App\Laraweather\Client;

/**
 * @method static getByCity(string $name)
 * @see Client::getByCity()
 */
class Weather extends \Illuminate\Support\Facades\Facade
{
    const BINDING_NAME = 'weather';

    protected static function getFacadeAccessor(): string
    {
        return self::BINDING_NAME;
    }
}
