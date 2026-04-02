<?php

namespace App\Enums;

enum UserRole : string
{
    case Admin = 'admin';
    case Mechanic = 'mechanic';
    case Schedular =  'schedular';
    case buyer =  'buyer';
    case User =  'user';
}
