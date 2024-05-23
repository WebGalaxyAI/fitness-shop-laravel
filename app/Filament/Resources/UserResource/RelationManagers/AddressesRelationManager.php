<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('country_iso')
                    ->required()
                    ->maxLength(2),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->maxLength(60),
                Forms\Components\TextInput::make('street')
                    ->required()
                    ->maxLength(60),
                Forms\Components\TextInput::make('zip_code')
                    ->required()
                    ->maxLength(15),
                Forms\Components\TextInput::make('house_number')
                    ->required()
                    ->maxLength(10),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('city')
            ->columns([
                Tables\Columns\TextColumn::make('country_iso'),
                Tables\Columns\TextColumn::make('city')->wrap(),
                Tables\Columns\TextColumn::make('street')->wrap(),
                Tables\Columns\TextColumn::make('house_number'),
                Tables\Columns\TextColumn::make('zip_code'),
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
