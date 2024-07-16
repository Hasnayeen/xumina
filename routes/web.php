<?php

use Hasnayeen\Xumina\Facades\Xumina;
use Hasnayeen\Xumina\Pages\AuthPage;
use Hasnayeen\Xumina\Panel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::name('xumina.')
    ->group(
        fn () => Xumina::getPanels()->each(
            fn (Panel $panel) => Route::name(Str::kebab($panel->getName()).'.')
                ->prefix($panel->getPrefix())
                ->middleware($panel->getMiddlewares())
                ->group(
                    fn () => $panel->getPages()
                        ->each(
                            function ($page) {
                                if (is_subclass_of($page, AuthPage::class)) {
                                    $page::routes();
                                } else {
                                    Route::middleware('auth', ...$page::getMiddlewares())
                                        ->group(
                                            fn () => $page::routes()
                                        );
                                }
                            }
                        )
                )
        )
    );
