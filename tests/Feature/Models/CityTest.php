<?php
use App\Models\City;

uses(classAndTraits: \Illuminate\Foundation\Testing\RefreshDatabase::class);

test(description: 'Models\City CRUD', closure: function () {
    $city = City::factory()->create(attributes: [
        'name' => 'My City',
        'country' => 'BR',
        'lon' => -46.7269,
        'lat' => -23.3217,
    ]);
    $this->assertDatabaseHas(table: City::class, data: $city->toArray());

    $city->name = 'Franco da Rocha';
    $city->save();
    $this->assertDatabaseHas(table: City::class, data: $city->toArray());

    $city->delete();
    $this->assertSoftDeleted(table: City::class, data: $city->toArray());

    $city = new City(attributes: City::factory()->make()->toArray());
    $this->assertInstanceOf(expected: City::class, actual: $city);
    $this->assertDatabaseMissing(table: City::class, data: $city->toArray());
    $city->save();
    $this->assertDatabaseHas(table: City::class, data: $city->toArray());
});
