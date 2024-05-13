<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SourceOfFunds: int implements HasLabel
{
    case Employment = 1;
    case Business = 2;
    case Inheritance = 3;
    case Remittance = 4;
    case Others = 5;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Employment => 'Employment',
            self::Business => 'Business',
            self::Inheritance => 'Inheritance',
            self::Remittance => 'Remittance',
            self::Others => 'Others',
        };
    }
}
