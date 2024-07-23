<?php

namespace Hasnayeen\Xumina\Enums;

enum ComponentType: string
{
    case Container = 'Container';
    case SideBar = 'SideBar';
    case TopBar = 'TopBar';
    case Breadcrumb = 'Breadcrumb';
    case PageHeader = 'PageHeader';
    case Content = 'Content';
    case UserMenu = 'UserMenu';
    case Separator = 'Separator';
    case Search = 'Search';
    case Trigger = 'Trigger';
    case ThemeSwitcher = 'ThemeSwitcher';
    case MobileNavigation = 'MobileNavigation';
    case Logo = 'Logo';
    case Notification = 'Notification';
    case Navigation = 'Navigation';
    case Action = 'Action';
    case Badge = 'Badge';
    case Form = 'Form';
    case Section = 'Section';
    case Field = 'Field';
    case Table = 'Table';
    case Dashlet = 'Dashlet';
    case Label = 'Label';
}
