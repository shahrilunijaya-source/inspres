<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_no', 'module', 'applicant_user_id', 'branch_id', 'status',
        'priority_level', 'sla_due_at', 'sla_status', 'estimated_completion_at',
        'demo_current_step', 'submitted_at', 'assigned_officer_id',
        'approved_by_officer_id', 'approved_at', 'officer_remarks',
    ];

    protected $casts = [
        'sla_due_at' => 'datetime',
        'estimated_completion_at' => 'datetime',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public const MODULES = [
        'birth' => 'Pendaftaran Kelahiran',
        'mykad' => 'Permohonan MyKad',
        'marriage' => 'Pendaftaran Perkahwinan',
        'death' => 'Pendaftaran Kematian',
        'adoption' => 'Anak Angkat',
        'citizenship' => 'Kewarganegaraan',
    ];

    public const STATUS_LABELS = [
        'draft' => 'Draf',
        'submitted' => 'Dihantar',
        'payment_pending' => 'Menunggu Bayaran',
        'payment_completed' => 'Bayaran Selesai',
        'doc_review' => 'Semakan Dokumen',
        'officer_review' => 'Semakan Pegawai',
        'approved' => 'Diluluskan',
        'cert_generated' => 'Sijil Dijana',
        'completed' => 'Selesai',
        'rejected' => 'Ditolak',
    ];

    public const TRACKER_STEPS = [
        'draft' => 1,
        'submitted' => 2,
        'payment_pending' => 3,
        'payment_completed' => 3,
        'doc_review' => 4,
        'officer_review' => 5,
        'approved' => 6,
        'cert_generated' => 7,
        'completed' => 8,
        'rejected' => 0,
    ];

    public const SLA_DAYS = [
        'birth' => 3,
        'mykad' => 5,
        'marriage' => 7,
        'death' => 3,
        'adoption' => 14,
        'citizenship' => 30,
    ];

    public function moduleLabel(): string
    {
        return self::MODULES[$this->module] ?? $this->module;
    }

    public function statusLabel(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    public function trackerStep(): int
    {
        return self::TRACKER_STEPS[$this->status] ?? 1;
    }

    public function slaDaysRemaining(): ?int
    {
        if (!$this->sla_due_at) return null;
        return (int) round(now()->diffInDays($this->sla_due_at, false));
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'applicant_user_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function assignedOfficer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_officer_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_officer_id');
    }

    public function birth(): HasOne
    {
        return $this->hasOne(BirthApplication::class);
    }

    public function mykad(): HasOne
    {
        return $this->hasOne(MykadApplication::class);
    }

    public function marriage(): HasOne
    {
        return $this->hasOne(MarriageApplication::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class)->orderBy('created_at');
    }
}
