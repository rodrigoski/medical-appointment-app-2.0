<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected $fillable = [
        'name',
        'provider',
        'policy_number',
        'coverage_type',
        'phone',
        'email',
        'status',
        'description',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
