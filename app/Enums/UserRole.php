<?php

namespace App\Enums;

enum UserRole : string
{
    case Admin = 'admin';
    case Mechanic = 'mechanic';
    case Schedular =  'schedular';
    case Buyer =  'buyer';
    case User =  'user';
}
