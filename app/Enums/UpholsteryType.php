<?php

namespace App\Enums;

enum UpholsteryType : string
{
    case Leather            = 'leather';
    case Fabric             = 'fabric';
    case Sheepskin          = 'sheepskin';
    case ArtificialLeather  = 'artificial_leather';
    case Metal              = 'metal';
}
