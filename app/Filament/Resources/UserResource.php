<?php

namespace App\Filament\Resources;

use App\Data\PersonData;
use App\Enums\OccupationRank;
use App\Enums\SourceOfFunds;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name'),
                Forms\Components\TextInput::make('email'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn (string $state): string => $state)
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),
                Forms\Components\Section::make('spouse')
                    ->schema(PersonData::FilamentForm('spouse.')),
                Forms\Components\Radio::make('spouse.occupation_rank')
                    ->label('Spouse:')
                    ->options(OccupationRank::class),
                Forms\Components\CheckboxList::make('spouse.source_of_funds')
                    ->label('Spouse:')
                    ->options(SourceOfFunds::class)
                    ->dehydrateStateUsing(
                        // https://github.com/spatie/laravel-data/pull/776
                        fn ($state) => array_map(
                            fn ($source_of_funds) => $source_of_funds instanceof SourceOfFunds ? $source_of_funds->value : $source_of_funds, $state
                        )
                    ),
                Forms\Components\View::make('dump'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('spouse.lastname'),
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
