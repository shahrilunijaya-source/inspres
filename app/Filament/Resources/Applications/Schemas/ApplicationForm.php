<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('app_no')
                    ->required(),
                Select::make('module')
                    ->options([
            'birth' => 'Birth',
            'mykad' => 'Mykad',
            'marriage' => 'Marriage',
            'death' => 'Death',
            'adoption' => 'Adoption',
            'citizenship' => 'Citizenship',
        ])
                    ->required(),
                TextInput::make('applicant_user_id')
                    ->required()
                    ->numeric(),
                Select::make('branch_id')
                    ->relationship('branch', 'name'),
                Select::make('status')
                    ->options([
            'draft' => 'Draft',
            'submitted' => 'Submitted',
            'payment_pending' => 'Payment pending',
            'payment_completed' => 'Payment completed',
            'doc_review' => 'Doc review',
            'officer_review' => 'Officer review',
            'approved' => 'Approved',
            'cert_generated' => 'Cert generated',
            'completed' => 'Completed',
            'rejected' => 'Rejected',
        ])
                    ->default('draft')
                    ->required(),
                Select::make('priority_level')
                    ->options(['high' => 'High', 'medium' => 'Medium', 'normal' => 'Normal'])
                    ->default('normal')
                    ->required(),
                DateTimePicker::make('sla_due_at'),
                Select::make('sla_status')
                    ->options([
            'on_track' => 'On track',
            'due_soon' => 'Due soon',
            'breach_risk' => 'Breach risk',
            'breached' => 'Breached',
        ])
                    ->default('on_track')
                    ->required(),
                DateTimePicker::make('estimated_completion_at'),
                TextInput::make('demo_current_step')
                    ->required()
                    ->numeric()
                    ->default(1),
                DateTimePicker::make('submitted_at'),
                Select::make('assigned_officer_id')
                    ->relationship('assignedOfficer', 'name'),
                TextInput::make('approved_by_officer_id')
                    ->numeric(),
                DateTimePicker::make('approved_at'),
                Textarea::make('officer_remarks')
                    ->columnSpanFull(),
            ]);
    }
}
