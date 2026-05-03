<?php

namespace App\Filament\Resources\Applications\Pages;

use App\Filament\Resources\Applications\ApplicationResource;
use Filament\Resources\Pages\ListRecords;

class ListApplications extends ListRecords
{
    protected static string $resource = ApplicationResource::class;

    public function getTitle(): string
    {
        return 'Antrian Kerja Pegawai';
    }

    public function getSubheading(): ?string
    {
        return 'Permohonan disusun mengikut keutamaan SLA. High = breach risk atau lebih 3 hari.';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
