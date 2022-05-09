<?php

dataset(name: 'weatherapi/openweatherapi/weather', dataset: function () {
    $filename = dirname(path: __DIR__)
        . DIRECTORY_SEPARATOR
        . 'json'
        . DIRECTORY_SEPARATOR
        . 'weather-apis'
        . DIRECTORY_SEPARATOR
        . 'openweatherapi'
        . DIRECTORY_SEPARATOR
        . 'weather_return.json';
    return [fopen(filename: $filename, mode: 'r')];
});
