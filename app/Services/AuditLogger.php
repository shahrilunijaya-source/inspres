<?php

namespace App\Services;

use App\Models\Application;
use App\Models\AuditLog;
use App\Models\User;

class AuditLogger
{
    public static function log(
        ?Application $application,
        ?User $user,
        string $action,
        ?string $statusBefore = null,
        ?string $statusAfter = null,
        ?string $remarks = null,
    ): AuditLog {
        return AuditLog::create([
            'application_id' => $application?->id,
            'user_id' => $user?->id,
            'user_role' => $user?->role,
            'user_label' => $user ? ($user->roleLabel() . ' — ' . $user->name) : 'Sistem',
            'action' => $action,
            'status_before' => $statusBefore,
            'status_after' => $statusAfter,
            'remarks' => $remarks,
            'created_at' => now(),
        ]);
    }
}
