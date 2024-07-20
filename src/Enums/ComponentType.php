<?php

namespace Hasnayeen\Xumina\Enums;

enum ComponentType: string
{
    case Action = 'Action';
    case Badge = 'Badge';
    case Form = 'Form';
    case Section = 'Section';
    case Field = 'Field';
    case Table = 'Table';
    case Dashlet = 'Dashlet';
    case Label = 'Label';
}
