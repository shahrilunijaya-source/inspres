<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarriageApplication extends Model
{
    protected $fillable = [
        'application_id', 'groom_name', 'groom_nric', 'groom_religion',
        'bride_name', 'bride_nric', 'bride_religion',
        'witness1_name', 'witness1_nric', 'witness2_name', 'witness2_nric',
        'caveat_status', 'civil_status_check', 'appointment_at', 'appointment_location',
    ];

    protected $casts = [
        'appointment_at' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
