<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum EmploymentType: int implements HasLabel
{
    case Employed = 1;
    case SelfEmployed = 2;
    case OFWLandbased = 3;
    case OFWSeafarer = 4;
    case LicensedProfessional = 5;
    case WithFinancialSupport = 6;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Employed => 'Locally Employed',
            self::SelfEmployed => 'Self Employed',
            self::OFWLandbased => 'OFW Landbased',
            self::OFWSeafarer => 'OFW Seafarer',
            self::LicensedProfessional => 'Licensed Professional',
            self::WithFinancialSupport => 'With Financial Support',
        };
    }
}
