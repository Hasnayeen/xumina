<?php

namespace Hasnayeen\Xumina\Enums;

use Hasnayeen\Xumina\Themes\Catppuccin;
use Hasnayeen\Xumina\Themes\DefaultTheme;
use Hasnayeen\Xumina\Themes\Dracula;
use Hasnayeen\Xumina\Themes\EverForest;
use Hasnayeen\Xumina\Themes\GruvBox;
use Hasnayeen\Xumina\Themes\Material;
use Hasnayeen\Xumina\Themes\MidnightGold;
use Hasnayeen\Xumina\Themes\MoonLight;
use Hasnayeen\Xumina\Themes\Nord;
use Hasnayeen\Xumina\Themes\PaleNight;
use Hasnayeen\Xumina\Themes\PastelDream;
use Hasnayeen\Xumina\Themes\RosePine;
use Hasnayeen\Xumina\Themes\Summer;
use Hasnayeen\Xumina\Themes\SynthWave84;
use Hasnayeen\Xumina\Themes\TokyoNight;

enum ThemesEnum: string
{
    case Summer = Summer::class;
    case Catppuccin = Catppuccin::class;
    case DefaultTheme = DefaultTheme::class;
    case Dracula = Dracula::class;
    case EverForest = EverForest::class;
    case GruvBox = GruvBox::class;
    case Material = Material::class;
    case MidnightGold = MidnightGold::class;
    case MoonLight = MoonLight::class;
    case Nord = Nord::class;
    case PaleNight = PaleNight::class;
    case PastelDream = PastelDream::class;
    case RosePine = RosePine::class;
    case SynthWave84 = SynthWave84::class;
    case TokyoNight = TokyoNight::class;
}
