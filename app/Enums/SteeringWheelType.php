<?php

namespace App\Enums;

enum SteeringWheelType : string
{
    case Round   = 'round';
    case Oval   = 'oval';
    case Stadium = 'stadium';
    case Hexagon   = 'hexagon';
}
