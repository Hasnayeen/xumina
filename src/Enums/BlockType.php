<?php

namespace Hasnayeen\Xumina\Enums;

enum BlockType: string
{
    case Container = 'Container';
    case SideBar = 'SideBar';
    case TopBar = 'TopBar';
    case Breadcrumb = 'Breadcrumb';
    case PageHeader = 'PageHeader';
    case Content = 'Content';
}
