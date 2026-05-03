<?php

namespace App\Filament\Resources\Applications\Tables;

use App\Models\Application;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('priority_level', 'desc')
            ->columns([
                TextColumn::make('app_no')
                    ->label('No. Permohonan')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('module')
                    ->label('Modul')
                    ->formatStateUsing(fn ($state) => Application::MODULES[$state] ?? $state)
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'birth' => 'success',
                        'mykad' => 'info',
                        'marriage' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('applicant.name')
                    ->label('Pemohon')
                    ->searchable()
                    ->description(fn ($record) => $record->applicant->nric ?? null),

                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => Application::STATUS_LABELS[$state] ?? $state)
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'completed', 'approved', 'cert_generated' => 'success',
                        'submitted', 'doc_review', 'officer_review', 'payment_completed' => 'info',
                        'payment_pending', 'draft' => 'gray',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('priority_level')
                    ->label('Keutamaan')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'high' => 'TINGGI',
                        'medium' => 'SEDERHANA',
                        'normal' => 'BIASA',
                        default => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'high' => 'danger',
                        'medium' => 'warning',
                        'normal' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('sla_status')
                    ->label('SLA')
                    ->badge()
                    ->formatStateUsing(fn ($state, $record) => match ($state) {
                        'on_track' => 'On Track (' . max(0, (int) round(now()->diffInDays($record->sla_due_at, false))) . 'h)',
                        'due_soon' => 'Due Soon',
                        'breach_risk' => 'Breach Risk',
                        'breached' => 'Breached',
                        default => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'on_track' => 'success',
                        'due_soon' => 'warning',
                        'breach_risk' => 'danger',
                        'breached' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('submitted_at')
                    ->label('Dihantar')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('assignedOfficer.name')
                    ->label('Pegawai')
                    ->placeholder('—')
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('module')
                    ->options(Application::MODULES),
                SelectFilter::make('status')
                    ->options(Application::STATUS_LABELS),
                SelectFilter::make('priority_level')
                    ->label('Keutamaan')
                    ->options(['high' => 'Tinggi', 'medium' => 'Sederhana', 'normal' => 'Biasa']),
                SelectFilter::make('sla_status')
                    ->label('SLA')
                    ->options([
                        'on_track' => 'On Track',
                        'due_soon' => 'Due Soon',
                        'breach_risk' => 'Breach Risk',
                        'breached' => 'Breached',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('approve')
                    ->label('Luluskan')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => in_array($record->status, ['officer_review', 'doc_review'], true))
                    ->action(function ($record) {
                        $before = $record->status;
                        $record->update([
                            'status' => 'approved',
                            'approved_by_officer_id' => auth()->id(),
                            'approved_at' => now(),
                        ]);
                        \App\Services\AuditLogger::log($record, auth()->user(), 'approve_application', $before, 'approved', 'Permohonan diluluskan oleh ' . auth()->user()->name);
                        \App\Services\SlaCalculator::refresh($record);
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}
