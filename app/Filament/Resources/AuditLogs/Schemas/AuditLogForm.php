<?php

namespace App\Filament\Resources\AuditLogs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AuditLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('application_id')
                    ->relationship('application', 'id'),
                Select::make('user_id')
                    ->relationship('user', 'name'),
                TextInput::make('user_role'),
                TextInput::make('user_label'),
                TextInput::make('action')
                    ->required(),
                TextInput::make('status_before'),
                TextInput::make('status_after'),
                Textarea::make('remarks')
                    ->columnSpanFull(),
            ]);
    }
}
