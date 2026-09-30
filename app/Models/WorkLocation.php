<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkLocation extends Model
{
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'radius_meter',
        'active',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'radius_meter' => 'integer',
        'active' => 'boolean',
    ];
}