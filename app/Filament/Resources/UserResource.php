<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tg_id')
                    ->label('tg_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('username')
                    ->label('USERNAME')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('referral_code')
                    ->label('Реферал')
                    ->options(User::all()->pluck('username', 'tg_id'))
                    ->searchable(),
                Forms\Components\TextInput::make('coins')
                    ->label('Монеты')
                    ->numeric(),
                Forms\Components\TextInput::make('energy')
                    ->label('Энергия')
                    ->numeric(),
                Forms\Components\TextInput::make('energy_max')
                    ->label('Макс. энергия')
                    ->numeric(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tg_id')->label('ID'),
                Tables\Columns\TextColumn::make('username')->label('Имя'),
                Tables\Columns\TextColumn::make('coins')->label('Монеты'),
                Tables\Columns\TextColumn::make('energy')->label('Энергия'),
                Tables\Columns\TextColumn::make('energy_max')->label('Макс. энергия'),
                Tables\Columns\TextColumn::make('referral_code')->label('Реферал'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
