<?php

namespace App\Laraweather;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Client
{
    public function getByCity(string $name): Response
    {
        return Http::get(
            url: 'http://weaterapi',
            query: ['q' => $name]
        );
    }
}
