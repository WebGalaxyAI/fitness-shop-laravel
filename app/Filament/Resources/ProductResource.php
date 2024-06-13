<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\AttributeValue;
use App\Models\Label;
use App\Models\Product;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductResource extends Resource
{
    use Translatable;

    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Catalog';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'products';

    public static function form(Form $form): Form
    {
        return $form->schema([
            SelectTree::make('categories')
                ->relationship('categories', 'name', 'parent_id'),
            Select::make('brand_id')
                ->relationship('brand', 'name')
                ->searchable()
                ->nullable(),
            TextInput::make('name')
                ->required(),
            TextInput::make('sku')
                ->required(),
            TextInput::make('slug'),
            TextInput::make('quantity')
                ->required()
                ->integer(),
            TextInput::make('price')
                ->required()
                ->numeric(),
            TextInput::make('sale_price')
                ->required()
                ->numeric(),
            Checkbox::make('active'),
            Checkbox::make('featured'),
            Select::make('attributeValues')
                ->label('Attributes')
                ->multiple()
                ->relationship(
                    name: 'attributeValues',
                    titleAttribute: 'value',
                    modifyQueryUsing: fn(Builder $query) => $query->withAttributeName(),
                )
                ->getOptionLabelFromRecordUsing(fn(AttributeValue $record) => "{$record->attribute->name} -> {$record->value}")
                ->searchable([
                    'value',
                    'attributes.name'
                ]),
            Select::make('labels')
                ->label('Labels')
                ->multiple()
                ->relationship(
                    name: 'labels',
                    titleAttribute: 'name',
                )
                ->getOptionLabelFromRecordUsing(fn(Label $record) => $record->name)
                ->searchable([
                    'name',
                ]),
            Placeholder::make('created_at')
                ->label('Created Date')
                ->content(fn(?Product $record): string => $record?->created_at?->diffForHumans() ?? '-'),
            Placeholder::make('updated_at')
                ->label('Last Modified Date')
                ->content(fn(?Product $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            SpatieMediaLibraryFileUpload::make('media')
                ->multiple()
                ->reorderable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->with('media'))
            ->columns([
                TextColumn::make('sku'),
                TextColumn::make('name')
                    ->searchable()
                    ->wrap()
                    ->sortable(),
                TextColumn::make('quantity'),
                ImageColumn::make('first_img_url')
                    ->label('Image'),
                TextColumn::make('price'),
                TextColumn::make('sale_price'),
                CheckboxColumn::make('active'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Action::make('site-view')
                    ->label('На сайті')
                    ->icon('heroicon-s-arrow-up-right')
                    ->color('success')
                    ->url(fn(Action $action): string => route('product', ['slug' => $action->getRecord()->slug]), true),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->filters([
                SelectFilter::make('categories')
                    ->relationship('categories', 'name'),
                SelectFilter::make('brand')
                    ->relationship('brand', 'name'),
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                Filter::make('sale_price')
                    ->form([
                        Forms\Components\TextInput::make('sale_price_from')->numeric(),
                        Forms\Components\TextInput::make('sale_price_to')->numeric(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['sale_price_from'],
                                fn(Builder $query, $price): Builder => $query->where('sale_price', '>=', $price * 100),
                            )
                            ->when(
                                $data['sale_price_to'],
                                fn(Builder $query, $price): Builder => $query->where('sale_price', '<=', $price * 100),
                            );
                    }),
                TernaryFilter::make('active')

            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['brand']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug', 'brand.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->brand) {
            $details['Brand'] = $record->brand->name;
        }

        return $details;
    }
}
