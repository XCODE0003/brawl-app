<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatLinkResource\Pages;
use App\Filament\Resources\StatLinkResource\RelationManagers;
use App\Models\StatLink;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StatLinkResource extends Resource
{
    protected static ?string $model = StatLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Название'),
                Tables\Columns\TextColumn::make('count_start')
                    ->label('Кол-во запусков количество'),
                Tables\Columns\TextColumn::make('link')
                    ->label('Ссылка')
                    ->formatStateUsing(fn(string $state): string => '/?rekl_start=' . $state)
                    ->copyable(),
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
            'index' => Pages\ListStatLinks::route('/'),
            'create' => Pages\CreateStatLink::route('/create'),
            'edit' => Pages\EditStatLink::route('/{record}/edit'),
        ];
    }
}
