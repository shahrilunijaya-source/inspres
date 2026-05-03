<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Certificate extends Model
{
    protected $fillable = [
        'application_id', 'cert_no', 'type', 'subject_name',
        'issued_by', 'issued_at', 'qr_token', 'preview_path', 'payload',
    ];

    protected $casts = [
        'issued_at' => 'date',
        'payload' => 'array',
    ];

    public const TYPE_LABELS = [
        'birth_cert' => 'Sijil Kelahiran',
        'mykad_slip' => 'Slip MyKad',
        'marriage_cert' => 'Sijil Perkahwinan',
        'death_cert' => 'Sijil Kematian',
        'adoption_cert' => 'Sijil Anak Angkat',
        'citizenship_cert' => 'Sijil Kewarganegaraan',
    ];

    public function typeLabel(): string
    {
        return self::TYPE_LABELS[$this->type] ?? $this->type;
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function verification(): HasOne
    {
        return $this->hasOne(CertificateVerification::class);
    }
}
