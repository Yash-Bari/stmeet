<?php

// app/Models/TempSession.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempSession extends Model
{
    protected $fillable = [
        'session_id',
        'is_available',
        'preferences',
        'last_active'
    ];

    protected $casts = [
        'preferences' => 'array',
        'is_available' => 'boolean',
        'last_active' => 'datetime'
    ];
}
