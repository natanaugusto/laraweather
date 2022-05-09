<?php

namespace App\Laraweather\Contracts;

use Illuminate\Http\Client\Response;

interface DriverInterface
{
    /**
     * The base URL for request
     * @return string
     */
    function getBaseUrl(): string;

    /**
     * The API Key for request
     * @return string
     */
    function getApiKey(): string;

    /**
     * Get a weather forecast from the API by the query passed
     * @param mixed $q
     * @return Response
     */
    function getFromAPI(mixed $q): Response;
}
