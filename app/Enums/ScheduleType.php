<?php

namespace App\Enums;

enum ScheduleType : string
{
    case Assembly = 'assembly';
    case Maintenance = 'maintenance';
}
