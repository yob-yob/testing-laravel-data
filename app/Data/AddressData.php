<?php

namespace App\Data;

use Filament\Forms;
use Spatie\LaravelData\Data;

class AddressData extends Data
{
    public function __construct(
        public ?string $no,
        public ?string $street,
        public ?string $subdivision,
        public ?string $brgy,
        public ?string $municipality,
        public ?string $city,
        public ?string $province,
        public ?string $country,
        public ?string $zip
    ) {
    }

    public static function FilamentForm($key = 'address')
    {
        return [
            Forms\Components\TextInput::make("{$key}.no")
                ->label('No.'),
            Forms\Components\TextInput::make("{$key}.street")
                ->label('Street'),
            Forms\Components\TextInput::make("{$key}.subdivision")
                ->label('Subdivision Name'),
            Forms\Components\TextInput::make("{$key}.brgy")
                ->label('Barangay')
                ->required(),
            Forms\Components\TextInput::make("{$key}.municipality")
                ->label('Municipal'),
            Forms\Components\TextInput::make("{$key}.city")
                ->label('City')
                ->required(),
            Forms\Components\TextInput::make("{$key}.province")
                ->label('Province')
                ->required(),
            Forms\Components\TextInput::make("{$key}.country")
                ->label('Country')
                ->required()
                ->default('Philippines'),
            Forms\Components\TextInput::make("{$key}.zip")
                ->label('Zip Code')
                ->validationAttribute('zip code')
                ->required(),
        ];
    }

    public static function fakeDataGenerator(): array
    {
        return [
            'no' => fake()->word(),
            'street' => fake()->streetAddress(),
            'subdivision' => fake()->word(),
            'brgy' => fake()->word(),
            'municipality' => fake()->word(),
            'city' => fake()->city(),
            'province' => fake()->word(),
            'country' => 'Philippines',
            'zip' => fake()->postcode(),
        ];
    }
}
