<?php
use App\Laraweather\Client;
use App\Laraweather\Contracts\WeatherInterface;
use Illuminate\Http\Client\Response as HttpClientResponse;
use Illuminate\Support\Facades\Http;
$weather = new class implements \App\Laraweather\Contracts\WeatherInterface {
    private array $args;

    public function getArgs(): ?array
    {
        return $this->args;
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
};
$driver = new class implements \App\Laraweather\Contracts\DriverInterface
{
    public function getBaseUrl(): string
    {
        return 'http://weaterapi';
    }

    public function getApiKey(): string
    {
        return 'API-KEY';
    }

    public function getFromAPI(mixed $q): HttpClientResponse
    {
        return Http::get(
            url: $this->getBaseUrl(),
            query: $q
        );
    }

    public function toQuery(WeatherInterface $query): array
    {
        return [
            'q' => $query->getName(),
            'appid' => $this->getApiKey()
        ];
    }

    public function toWeather(HttpClientResponse $response, WeatherInterface $weather = null): WeatherInterface
    {
        return $weather;
    }
};

test(description: 'Instaciate Laraweather/Client', closure: function ($weatherReturn) use ($driver, $weather) {
    mockHttp(body: $weatherReturn);
    $laraweather = new Client(driver: $driver, weather: $weather);
    $this->assertInstanceOf(
        expected: WeatherInterface::class,
        actual: $laraweather->getByCity(name: 'Franco da Rocha')
    );
})->with(data: 'weatherapi/openweatherapi/weather');
