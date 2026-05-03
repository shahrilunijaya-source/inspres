<?php

namespace App\Filament\Resources\AuditLogs\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AuditLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Masa')
                    ->dateTime('d M Y, H:i'),
                TextColumn::make('application.app_no')
                    ->label('No. Permohonan')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('user_label')
                    ->label('Pengguna')
                    ->wrap(),
                TextColumn::make('user_role')
                    ->label('Peranan')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'admin' => 'danger',
                        'supervisor' => 'warning',
                        'officer' => 'info',
                        'public' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('action')
                    ->label('Tindakan')
                    ->formatStateUsing(fn ($state) => str_replace('_', ' ', ucfirst($state))),
                TextColumn::make('status_before')
                    ->label('Sebelum')
                    ->placeholder('—'),
                TextColumn::make('status_after')
                    ->label('Selepas')
                    ->placeholder('—'),
                TextColumn::make('remarks')
                    ->label('Catatan')
                    ->wrap()
                    ->limit(60)
                    ->placeholder('—'),
            ])
            ->filters([
                SelectFilter::make('user_role')
                    ->options(['admin' => 'Admin', 'supervisor' => 'Supervisor', 'officer' => 'Officer', 'public' => 'Public', 'system' => 'System']),
            ]);
    }
}
