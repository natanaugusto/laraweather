<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'name' => 'string',
        'country' => 'string',
        'lon' => 'float:9,6',
        'lat' => 'float:8,6',
    ];

    protected $fillable = ['name', 'country', 'lon', 'lat'];

    public function forecasts(): HasMany
    {
        return $this->hasMany(related: Forecast::class);
    }
}
