<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BirthApplication extends Model
{
    protected $fillable = [
        'application_id', 'child_name', 'child_gender', 'child_dob',
        'child_time_of_birth', 'hospital', 'place_of_birth',
        'father_name', 'father_nric', 'mother_name', 'mother_nric', 'marriage_cert_no',
    ];

    protected $casts = [
        'child_dob' => 'date',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
