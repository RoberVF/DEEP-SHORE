<?php

namespace App\Enums;

enum Condition: string
{
    case New = 'new';
    case Good = 'good';
    case Worn = 'worn';
    case Damaged = 'damaged';
}
