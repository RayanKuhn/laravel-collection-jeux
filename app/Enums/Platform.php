<?php

namespace App\Enums;

enum Platform: string
{
    case PS1 = 'PS1';
    case PS2 = 'PS2';
    case PS3 = 'PS3';
    case PS4 = 'PS4';
    case PS5 = 'PS5';
    case Xbox = 'Xbox';
    case Xbox360 = 'Xbox 360';
    case XboxOne = 'Xbox One';
    case Switch = 'Switch';
    case PC = 'PC';
    case PSP = "PSP";
    case GB = "Gameboy";
    case GBC = "Gameboy Color";
    case GBA = "Gameboy Advance";
    case DS = "DS";
    case TroisDS = "3DS";
    case PSVita = "PS Vita";
    case Autre = 'Autre';
}
