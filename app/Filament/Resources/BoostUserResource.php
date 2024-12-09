<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoostUserResource\Pages;
use App\Filament\Resources\BoostUserResource\RelationManagers;
use App\Models\BoostUsers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BoostUserResource extends Resource
{
    protected static ?string $model = BoostUsers::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->searchable()
                    ->relationship('user', 'username')
                    ->label('Пользователь')
                    ->required(),
                Forms\Components\Select::make('boost_id')
                    ->searchable()
                    ->relationship('boost', 'name')
                    ->label('Буст')
                    ->required(),
                Forms\Components\TextInput::make('lvl')
                    ->label('Уровень')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.username')
                    ->label('Пользователь'),
                Tables\Columns\TextColumn::make('boost.name')
                    ->label('Буст'),
                Tables\Columns\TextColumn::make('lvl')
                    ->label('Уровень'),
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
            'index' => Pages\ListBoostUsers::route('/'),
            'create' => Pages\CreateBoostUser::route('/create'),
            'edit' => Pages\EditBoostUser::route('/{record}/edit'),
        ];
    }
}