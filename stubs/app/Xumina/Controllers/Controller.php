<?php

namespace App\Xumina\{{ $panel }}\Controllers;

use {{ $modelFqcn }};
use App\Xumina\{{ $panel }}\Pages\{{ $resource }}\Create{{ $model }};
use App\Xumina\{{ $panel }}\Pages\{{ $resource }}\Edit{{ $model }};
use App\Xumina\{{ $panel }}\Pages\{{ $resource }}\List{{ $model }};
use App\Xumina\{{ $panel }}\Pages\{{ $resource }}\View{{ $model }};
use Hasnayeen\Xumina\Xumina;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class {{ $model }}Controller
{
    public function index(Request $request, List{{ $model }} $page): Response
    {
        return Inertia::render(Xumina::getInertiaPath($request->route()->getName()), [
            'data' => $page->data(),
        ]);
    }

    public function show(Request $request, {{ $model }} ${{ $modelVar }},  View{{ $model }} $page): Response
    {
        $page->record(${{ $modelVar }});

        return Inertia::render(Xumina::getInertiaPath($request->route()->getName()), [
            'data' => $page->data(),
        ]);
    }

    public function create(Request $request, Create{{ $model }} $page): Response
    {
        return Inertia::render(Xumina::getInertiaPath($request->route()->getName()), [
            'data' => $page->data(),
        ]);
    }

    public function store(Request $request, Create{{ $model }} $page)
    {
        return $page->save($request->all(), '{{ $modelKebab }}');
    }

    public function edit(Request $request, {{ $model }} ${{ $modelVar }}, Edit{{ $model }} $page)
    {
        $page->record(${{ $modelVar }});

        return Inertia::render(Xumina::getInertiaPath($request->route()->getName()), [
            'data' => $page->data(),
        ]);
    }

    public function update(Request $request, {{ $model }} ${{ $modelVar }}, Edit{{ $model }} $page)
    {
        return $page->save($request->all(), '{{ $modelKebab }}', ${{ $modelVar }});
    }

    public function destroy({{ $model }} ${{ $modelVar }}, View{{ $model }} $page)
    {
        return $page->delete(${{ $modelVar }});
    }
}
