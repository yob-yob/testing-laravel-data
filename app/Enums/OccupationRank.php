<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum OccupationRank: int implements HasLabel
{
    case BusinessOwner = 1;
    case TopExecutive = 2;
    case ManagerSupervisor = 3;
    case RankAndFile = 4;
    case Others = 5;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::BusinessOwner => 'Business Owner',
            self::TopExecutive => 'Top Executive',
            self::ManagerSupervisor => 'Manager/Supervisor',
            self::RankAndFile => 'Rank & File',
            self::Others => 'Others',
        };
    }
}
