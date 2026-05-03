<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemoWalkthroughStep extends Model
{
    protected $fillable = [
        'step_no', 'title', 'description', 'route_name',
        'route_url', 'presenter_notes', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
