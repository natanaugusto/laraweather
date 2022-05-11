<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Forecast extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'description' => 'string',
        'min' => 'float:5,2',
        'max' => 'float:5,2',
        'feels' => 'float:5,2',
        'last_update' => 'datetime',
    ];

    protected $fillable = ['description', 'min', 'max', 'feels', 'last_update'];

    public function city(): BelongsTo
    {
        return $this->belongsTo(related: City::class);
    }
}
