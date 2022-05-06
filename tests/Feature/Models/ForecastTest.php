<?php

use App\Models\City;
use App\Models\Forecast;
use Illuminate\Support\Arr;

uses(classAndTraits: \Illuminate\Foundation\Testing\RefreshDatabase::class);

test(description: 'Models\Forecast CRUD', closure: function () {
    $forecast = Forecast::factory()->create();
    $this->assertDatabaseHas(table: Forecast::class, data: $forecast->toArray());

    $forecast->description = 'Raining';
    $forecast->save();
    $this->assertDatabaseHas(table: Forecast::class, data: $forecast->toArray());

    $forecast->delete();
    $this->assertSoftDeleted(table: Forecast::class, data: $forecast->toArray());

    $forecast = new Forecast(Arr::except(
        array: Forecast::factory()->make()->toArray(),
        keys: ['city_id']
    ));
    $forecast->city_id = City::factory()->create()->id;

    $this->assertInstanceOf(expected: Forecast::class, actual: $forecast);
    $this->assertDatabaseMissing(table: Forecast::class, data: $forecast->toArray());

    $forecast->save();
    $this->assertDatabaseHas(table: Forecast::class, data: $forecast->toArray());
});

test(description: 'Models\Forecast Relationship', closure: function () {
    $city = City::factory()->create();
    $forecast = Forecast::factory()->create([
        'city_id' => $city,
    ]);
    $this->assertInstanceOf(expected: City::class, actual: $forecast->city);
    $this->assertEquals(
        expected: $city->toArray(),
        actual: Arr::except(array: $forecast->city->toArray(), keys: ['deleted_at'])
    );
});
