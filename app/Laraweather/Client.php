<?php

namespace App\Laraweather;

use App\Laraweather\Contracts\DriverInterface;

use Illuminate\Http\Client\Response;

class Client
{
    protected DriverInterface $driver;

    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    public function getByCity(string $name): Response
    {
        return $this->driver->getFromAPI(q: ['q' => $name]);
    }
}
