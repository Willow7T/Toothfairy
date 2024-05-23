<?php

namespace App\Filament\Resources\DentistResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppointmentRelationManager extends RelationManager
{
    protected static string $relationship = 'appointmentswdentist';

    protected static ?string $title = 'Appointments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Appointment')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('appointment_date')
                    ->date()
                    ->label('Appointment Date'),
                TextColumn::make('patient.name'),
                ColumnGroup::make('Treatments', [
                    TextColumn::make('treatments.treatment.name')
                        ->label('Treatment')
                        ->listWithLineBreaks()
                        ->bulleted(),
                    TextColumn::make('treatments.quantity')
                        ->label('Quantity')
                        ->listWithLineBreaks()
                        ->bulleted()->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('treatments.price')
                        ->label('Price')
                        ->listWithLineBreaks()
                        ->bulleted()->toggleable(isToggledHiddenByDefault: true),
                ]),
                ColumnGroup::make('Price', [
                    TextColumn::make('calculated_fee')
                        ->label('Without Discount')
                        ->suffix(' kyats')->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('discount')
                        ->label('Discount')
                        ->suffix(' kyats')->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('total_fee')
                        ->label('Total Cost')
                        ->suffix(' kyats'),
                ]),

                SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])->toggleable(),

                TextColumn::make('discription')
                    ->label('Remarks')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
