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

    /**
     * Convert a WeatherInterface into an array
     * @param WeatherInterface $query
     * @return array
     */
    function toQuery(WeatherInterface $query): array;

    /**
     * Convert a Response object into a WeatherInterface
     * @param Response $response
     * @return WeatherInterface
     */
    function toWeather(Response $response): WeatherInterface;
}
