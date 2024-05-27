<?php

namespace App\Filament\Resources\AttributeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Mvenghaus\FilamentPluginTranslatableInline\Forms\Components\TranslatableContainer;

class ValuesRelationManager extends RelationManager
{
    protected static string $relationship = 'values';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('value')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('value')
            ->columns([
                Tables\Columns\TextColumn::make('value'),
                Tables\Columns\TextColumn::make('code'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->form([Grid::make()
                    ->schema([
                        TranslatableContainer::make(
                            TextInput::make('value')
                                ->maxLength(255)
                                ->required()
                        ),
                        TextInput::make('code')
                            ->required()
                            ->maxLength(255),
                    ])->columns()]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->form([Grid::make()
                    ->schema([
                        TranslatableContainer::make(
                            TextInput::make('value')
                                ->maxLength(255)
                                ->required()
                        ),
                        TextInput::make('code')
                            ->required()
                            ->maxLength(255),
                    ])->columns()]),
                Tables\Actions\EditAction::make()->form([Grid::make()
                    ->schema([
                        TranslatableContainer::make(
                            TextInput::make('value')
                                ->maxLength(255)
                                ->required()
                        ),
                        TextInput::make('code')
                            ->required()
                            ->maxLength(255),
                    ])->columns()]),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
