<?php

namespace App\Filament\Resources\AuditLogs\Pages;

use App\Filament\Resources\AuditLogs\AuditLogResource;
use Filament\Resources\Pages\ListRecords;

class ListAuditLogs extends ListRecords
{
    protected static string $resource = AuditLogResource::class;

    public function getTitle(): string
    {
        return 'Audit Trail';
    }

    public function getSubheading(): ?string
    {
        return 'Simulasi audit kekal — semua tindakan direkod dalam pangkalan data.';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
