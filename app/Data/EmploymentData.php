<?php

namespace App\Data;

use App\Enums\EmploymentType;
use App\Enums\OccupationRank;
use Filament\Forms;
use Filament\Support\RawJs;
use Spatie\LaravelData\Data;

class EmploymentData extends Data
{
    public function __construct(
        public EmploymentType $employment_type,
        public string $occupation,
        public string $position,
        public int $tenure,
        public string $gross_monthly_income,
        public string $employer_name,
        public string $employer_telephone,
        public string $employer_email,
        public AddressData $employer_address,
        public OccupationRank $occupation_rank,
    ) {
    }

    public static function FilamentForm($key = ''): array
    {
        return [
            Forms\Components\Select::make("{$key}employment_type")
                ->options(EmploymentType::class)
                ->columnSpanFull()
                ->required()
                ->live(),

            Forms\Components\Section::make()
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make("{$key}occupation")
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make("{$key}position")
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make("{$key}tenure")
                        ->suffix('years')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make("{$key}gross_monthly_income")
                        ->label('Gross Monthly Income')
                        ->prefix('₱')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->required()
                        ->dehydrateStateUsing(fn ($state) => empty($state) ? null : $state),
                ]),

            Forms\Components\Section::make()
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make("{$key}employer_name")
                        ->label('Employer/Business Name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make("{$key}employer_telephone")
                        ->label('Employer Telephone No.')
                        ->maxLength(255),
                    Forms\Components\TextInput::make("{$key}employer_email")
                        ->label('Employer Email')
                        ->maxLength(255),
                ]),

            Forms\Components\Fieldset::make('Employer/Business Address')
                ->columns(3)
                ->schema(AddressData::FilamentForm("{$key}employer_address")),
        ];
    }

    public static function fakeDataGenerator(): array
    {
        return [
            'employment_type' => fake()->randomElement(EmploymentType::cases()),
            'occupation' => fake()->name(),
            'position' => fake()->word(),
            'tenure' => fake()->numberBetween(10, 15),
            'gross_monthly_income' => fake()->numberBetween(50000, 100000),
            'employer_name' => fake()->word(),
            'employer_telephone' => fake()->phoneNumber(),
            'employer_email' => fake()->safeEmail(),
            'employer_address' => AddressData::fakeDataGenerator(),
            'occupation_rank' => fake()->randomElement(OccupationRank::cases()),
        ];
    }
}
