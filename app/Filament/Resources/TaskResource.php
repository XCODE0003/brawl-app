<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('Название')
                    ->maxLength(255),
                Forms\Components\TextInput::make('reward')
                    ->required()
                    ->numeric()
                    ->label('Награда'),
                Forms\Components\FileUpload::make('image')
                    ->required()
                    ->label('Изображение'),

                Forms\Components\Group::make([
                    Forms\Components\TextInput::make('channel_link')
                        ->label('Ссылка на канал'),
                    Forms\Components\TextInput::make('channel_id')
                        ->label('ID канала'),
                ])->columns(2),
                Forms\Components\Toggle::make('is_daily')
                    ->required()
                    ->label('Ежедневное задание'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Название'),
                Tables\Columns\TextColumn::make('reward')
                    ->label('Награда'),

                Tables\Columns\TextColumn::make('channel_link')
                    ->label('Ссылка на канал'),
                Tables\Columns\TextColumn::make('channel_id')
                    ->label('ID канала'),
                Tables\Columns\IconColumn::make('is_daily')
                    ->label('Ежедневное задание')
                    ->boolean(),
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
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}