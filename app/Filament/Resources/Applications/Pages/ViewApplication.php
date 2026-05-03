<?php

namespace App\Filament\Resources\Applications\Pages;

use App\Filament\Resources\Applications\ApplicationResource;
use App\Services\AuditLogger;
use App\Services\SlaCalculator;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\View\View;

class ViewApplication extends Page
{
    protected static string $resource = ApplicationResource::class;

    protected string $view = 'filament.applications.view';

    public $record;

    public function mount(int|string $record): void
    {
        $this->record = ApplicationResource::getModel()::with([
            'applicant', 'birth', 'mykad', 'marriage', 'documents', 'payments',
            'certificate', 'auditLogs.user', 'assignedOfficer', 'branch',
        ])->findOrFail($record);
        SlaCalculator::refresh($this->record);
        $this->record->refresh();
    }

    public function getTitle(): string
    {
        return $this->record->moduleLabel() . ' — ' . $this->record->app_no;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('approve')
                ->label('Luluskan Permohonan')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn () => in_array($this->record->status, ['officer_review', 'doc_review', 'submitted'], true))
                ->action(function () {
                    $before = $this->record->status;
                    $this->record->update([
                        'status' => 'approved',
                        'approved_by_officer_id' => auth()->id(),
                        'approved_at' => now(),
                    ]);
                    AuditLogger::log($this->record, auth()->user(), 'approve_application', $before, 'approved', 'Permohonan diluluskan.');
                    SlaCalculator::refresh($this->record);
                    $this->record->refresh();
                }),
            Action::make('verify_docs')
                ->label('Sahkan Semua Dokumen')
                ->icon('heroicon-o-document-check')
                ->color('info')
                ->visible(fn () => $this->record->documents->where('verified', false)->isNotEmpty())
                ->action(function () {
                    $this->record->documents()->update([
                        'verified' => true,
                        'verified_by' => auth()->id(),
                        'verified_at' => now(),
                    ]);
                    AuditLogger::log($this->record, auth()->user(), 'verify_documents', $this->record->status, $this->record->status, 'Semua dokumen disahkan.');
                    $this->record->refresh();
                }),
        ];
    }
}
