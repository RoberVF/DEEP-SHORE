<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum UserRole: string implements HasLabel, HasColor
{
    case Admin = 'admin';
    case Manager = 'manager';
    case Operator = 'operator';
    case User = 'user';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Admin => 'danger',
            self::Manager => 'warning',
            self::Operator => 'info',
            self::User => 'gray',
        };
    }
}
