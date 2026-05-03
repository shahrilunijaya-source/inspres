<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MykadApplication extends Model
{
    protected $fillable = [
        'application_id', 'type', 'full_name', 'nric', 'dob',
        'reason', 'photo_path', 'biometric_status', 'blacklist_check',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
