<?php
use App\Laraweather\Client;
use App\Laraweather\Contracts\WeatherInterface;
use Illuminate\Http\Client\Response as HttpClientResponse;
use Illuminate\Support\Facades\Http;
$weather = new class implements \App\Laraweather\Contracts\WeatherInterface {
    private array $args;
    private array $raw;

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
        $body = json_decode(
            json: $response->body(),
            associative: true
        );
        $weather->setRaw(value: $body);
        $weather->setName(value: $body['name']);
        $weather->setCountry(value: $body['sys']['country']);
        $weather->setDescription(value: $body['weather'][0]['description']);
        $weather->setLonLat(lon: $body['coord']['lon'], lat: $body['coord']['lat']);
        $weather->setMin(value: $body['main']['temp_min']);
        $weather->setMax(value: $body['main']['temp_max']);
        $weather->setFeels(value: $body['main']['feels_like']);
        return $weather;
    }
};

test(description: 'Instaciate Laraweather/Client', closure: function ($weatherReturn) use ($driver, $weather) {
    mockHttp(body: $weatherReturn);
    $laraweather = new Client(driver: $driver, weather: $weather);
    $weather = $laraweather->getByCity(name: 'Franco da Rocha');
    $this->assertInstanceOf(
        expected: WeatherInterface::class,
        actual: $weather
    );
    $this->assertEquals(
        expected: [
            'name' => 'Franco da Rocha',
            'country' => 'BR',
            'description' => 'scattered clouds',
            'lon' => -46.7269,
            'lat' => -23.3217,
            'min' => 288.48,
            'max' => 292.63,
            'feels' => 290.57
        ],
        actual: $weather->getArgs()
    );

    $meta = stream_get_meta_data(stream: $weatherReturn);
    $this->assertEquals(
        expected: json_decode(
            json: file_get_contents(filename: $meta['uri']),
            associative: true
        ),
        actual: $weather->getRaw()
    );
})->with(data: 'weatherapi/openweatherapi/weather');
