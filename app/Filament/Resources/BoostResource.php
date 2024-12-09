<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoostResource\Pages;
use App\Filament\Resources\BoostResource\RelationManagers;
use App\Models\Boost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BoostResource extends Resource
{
    protected static ?string $model = Boost::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Название')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->required()
                    ->label('Изображение'),
                Forms\Components\Repeater::make('lvl_prices')
                    ->schema([
                        Forms\Components\TextInput::make('lvl')
                            ->label('Уровень')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('income_per_hour')
                            ->label('Добыча в час')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('price')
                            ->label('Цена')
                            ->numeric()
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\ImageColumn::make('image'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBoosts::route('/'),
            'create' => Pages\CreateBoost::route('/create'),
            'edit' => Pages\EditBoost::route('/{record}/edit'),
        ];
    }
}
