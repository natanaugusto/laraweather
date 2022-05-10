<?php

namespace App\Laraweather;

use App\Laraweather\Contracts\WeatherInterface;
use Illuminate\Support\Carbon;

class Weather implements WeatherInterface
{
    protected array $args;
    protected array $raw;

    public function getArgs(): ?array
    {
        return $this->args ?? null;
    }

    public function setArgs(array $args): void
    {
        $this->args = $args;
    }

    public function getName(): ?string
    {
        return $this->args['name'] ?? null;
    }

    public function setName(string $value): void
    {
        $this->args['name'] = $value;
    }

    public function getCountry(): ?string
    {
        return $this->args['country'] ?? null;
    }

    public function setCountry(string $value): void
    {
        $this->args['country'] = $value;
    }

    public function getDescription(): ?string
    {
        return $this->args['description'] ?? null;
    }

    public function setDescription(string $value): void
    {
        $this->args['description'] = $value;
    }

    public function getLonLat(): ?array
    {
        if (empty($this->args['lon']) || empty($this->args['lat'])) {
            return null;
        }
        return [$this->args['lon'], $this->args['lat']];
    }

    public function setLonLat(float $lon, float $lat): void
    {
        $this->args['lon'] = $lon;
        $this->args['lat'] = $lat;
    }

    public function getMin(): ?float
    {
        return $this->args['min'] ?? null;
    }

    public function setMin(float $value): void
    {
        $this->args['min'] = $value;
    }

    public function getMax(): ?float
    {
        return $this->args['max'] ?? null;
    }

    public function setMax(float $value): void
    {
        $this->args['max'] = $value;
    }

    public function getFeels(): ?float
    {
        return $this->args['feels'] ?? null;
    }

    public function setFeels(float $value): void
    {
        $this->args['feels'] = $value;
    }

    public function getRaw(): ?array
    {
        return $this->raw ?? null;
    }

    public function setRaw(array $value): void
    {
        $this->raw = $value;
    }

    public function getLastUpdate(): ?string
    {
        return $this->args['last_update'] ?? null;
    }

    public function setLastUpdate(Carbon $date): void
    {
        $this->args['last_update'] = $date->format(format: 'Y-m-d H:i:s');
    }
}
