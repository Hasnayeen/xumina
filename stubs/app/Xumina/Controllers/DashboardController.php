<?php

namespace App\Xumina\{{ $panel }}\Controllers;

use App\Xumina\{{ $panel }}\Pages\Dashboard;
use Hasnayeen\Xumina\Xumina;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController
{
    public function __invoke(Request $request, Dashboard $page): Response
    {
        return Inertia::render(Xumina::getInertiaPath($request->route()->getName()), [
            'data' => $page->data(),
        ]);
    }
}
