<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Mechanic = 'mechanic';
    case Planner =  'planner';
    case buyer =  'buyer';
    case User =  'user';
}
