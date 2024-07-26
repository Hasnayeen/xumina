<?php

namespace App\Xumina\{{ $panel }}\Pages;

use App\Xumina\{{ $panel }}\Controllers\DashboardController;
use Hasnayeen\Xumina\Page;
use Hasnayeen\Xumina\Facades\Xumina;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class Dashboard extends Page
{
    protected static string | null $title = 'Dashboard';

    protected static string | null $panel = '{{ $panel }}';

    public function outline(): array
    {
        return [];
    }

    public static function routes(): array
    {
        return [
            Route::get('dashboard', DashboardController::class)
                ->name('dashboard'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return "Dashboard";
    }

    public static function getNavigationRouteName(): string
    {
        return 'xumina.'.Str::kebab(Xumina::getCurrentPanel()->getName()).'.'.'dashboard';
    }

    public static function getNavigationOrder(): int
    {
        return 0;
    }

    public static function getNavigationIcon(): string
    {
        return 'house';
    }

    public static function isNavigationActive(): bool
    {
        return request()->routeIs('xumina.'.Str::kebab(static::getPanelName()).'.dashboard');
    }
}
