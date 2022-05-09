<?php

namespace App\Laraweather\Contracts;

interface WeatherInterface
{
    function getArgs(): ?array;
    function setArgs(array $args): void;

    function getName(): ?string;
    function setName(string $value): void;

    function getCountry(): ?string;
    function setCountry(string $value): void;

    function getDescription(): ?string;
    function setDescription(string $value): void;

    function getLonLat(): ?array;
    function setLonLat(float $lon, float $lat): void;

    function getMin(): ?float;
    function setMin(float $value): void;

    function getMax(): ?float;
    function setMax(float $value): void;

    function getFeels(): ?float;
    function setFeels(float $value): void;

    function getRaw(): ?array;
    function setRaw(array $value): void;
}
