<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Forecast extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'description' => 'string',
        'min' => 'float:4,2',
        'max' => 'float:4,2',
        'feels' => 'float:4,2',
    ];

    protected $fillable = ['description', 'min', 'max', 'feels'];

}
