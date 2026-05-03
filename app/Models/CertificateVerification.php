<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificateVerification extends Model
{
    protected $fillable = [
        'certificate_id', 'certificate_no', 'verification_code',
        'verification_url', 'status', 'last_verified_at', 'verify_count',
    ];

    protected $casts = [
        'last_verified_at' => 'datetime',
    ];

    public function certificate(): BelongsTo
    {
        return $this->belongsTo(Certificate::class);
    }
}
