<?php

namespace App\Enums;

enum RouteStatus: string
{
    case Planned = 'planned';
    case Active = 'active';
    case Completed = 'completed';
    case Aborted = 'aborted';
}
