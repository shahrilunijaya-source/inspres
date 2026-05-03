<?php

namespace App\Services;

use App\Models\Application;
use Carbon\Carbon;

class SlaCalculator
{
    public static function dueAt(string $module, ?Carbon $submittedAt = null): Carbon
    {
        $days = Application::SLA_DAYS[$module] ?? 5;
        return ($submittedAt ?? now())->copy()->addDays($days);
    }

    public static function status(?Carbon $dueAt): string
    {
        if (!$dueAt) return 'on_track';

        $now = now();
        if ($now->gt($dueAt)) return 'breached';

        $hoursRemaining = $now->diffInHours($dueAt, false);

        if ($hoursRemaining <= 24) return 'breach_risk';
        if ($hoursRemaining <= 48) return 'due_soon';

        return 'on_track';
    }

    public static function priority(string $slaStatus, bool $hasMissingDocs = false, ?Carbon $submittedAt = null): string
    {
        if (in_array($slaStatus, ['breached', 'breach_risk'], true)) return 'high';
        if ($submittedAt && $submittedAt->lt(now()->subDays(3))) return 'high';
        if ($hasMissingDocs || $slaStatus === 'due_soon') return 'medium';
        return 'normal';
    }

    public static function refresh(Application $application): void
    {
        if (!$application->sla_due_at) return;

        $newStatus = self::status($application->sla_due_at);
        $hasMissingDocs = $application->documents()->where('verified', false)->exists();
        $newPriority = self::priority($newStatus, $hasMissingDocs, $application->submitted_at);

        $application->forceFill([
            'sla_status' => $newStatus,
            'priority_level' => $newPriority,
        ])->save();
    }
}
