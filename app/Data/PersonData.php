<?php

namespace App\Data;

use App\Enums\SourceOfFunds;
use Carbon\CarbonImmutable;
use Filament\Forms;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class PersonData extends Data
{
    public function __construct(
        public string $lastname,
        public string $firstname,
        public string $middlename,
        public CarbonImmutable $birthdate,
        public string $birthplace,
        public string $citizenship,
        public string $telephone,
        public string $mobile,
        public string $email,
        public string $sss_gsis,
        public string $tin,
        /** @var Collection<int, \App\Enums\SourceOfFunds> */
        public Collection $source_of_funds,
        public EmploymentData $employment,
    ) {
    }

    public static function FilamentForm($key = '')
    {
        return [
            Forms\Components\Grid::make([
                'lg' => 3,
            ])->schema([
                Forms\Components\TextInput::make("{$key}lastname")
                    ->label('Last name')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\TextInput::make("{$key}firstname")
                    ->label('First name')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\TextInput::make("{$key}middlename")
                    ->label('Middle name')
                    ->maxLength(255)
                    ->required(),
            ]),
            Forms\Components\DatePicker::make("{$key}birthdate")
                ->label('Date of birth')
                ->required()
                ->date(),
            Forms\Components\TextInput::make("{$key}birthplace")
                ->label('Birth place')
                ->maxLength(255)
                ->required(),
            Forms\Components\TextInput::make("{$key}citizenship")
                ->label('Citizenship')
                ->required(),
            Forms\Components\TextInput::make("{$key}telephone")
                ->label('Telephone No.'),
            Forms\Components\TextInput::make("{$key}mobile")
                ->label('Mobile no.')
                ->prefix('+63')
                ->required(),
            Forms\Components\TextInput::make("{$key}email")
                ->label('Email')
                ->email(),
            Forms\Components\TextInput::make("{$key}sss_gsis")
                ->label('SSS/GSIS/UMID'),
            Forms\Components\TextInput::make("{$key}tin")
                ->required()
                ->label('TIN'),
            ...EmploymentData::FilamentForm("{$key}employment."),
        ];
    }

    public static function fakeDataGenerator(): array
    {
        return [
            'lastname' => fake()->lastName(),
            'firstname' => fake()->firstName(),
            'middlename' => fake()->lastName(),
            'birthdate' => fake()->date(max: now()->subYears(18)),
            'birthplace' => fake()->city(),
            'citizenship' => 'Filipino',
            'telephone' => fake()->phoneNumber(),
            'mobile' => substr(fake()->e164PhoneNumber(), 3),
            'email' => fake()->email(),
            'sss_gsis' => fake()->randomNumber(5),
            'tin' => fake()->randomNumber(5),
            'source_of_funds' => [
                SourceOfFunds::Employment->value,
            ],
            'employment' => EmploymentData::fakeDataGenerator(),
        ];
    }
}
