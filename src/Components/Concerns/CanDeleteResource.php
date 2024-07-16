<?php

namespace Hasnayeen\Xumina\Components\Concerns;

use Illuminate\Database\Eloquent\Model;

trait CanDeleteResource
{
    public function delete(Model $model)
    {
        try {
            $model->delete();

            return redirect()
                ->route(static::getNavigationRoute())
                ->with('message', class_basename($model).' deleted successfully')
                ->with('type', 'success');
        } catch (\Exception $e) {
            return back()
                ->with('message', 'Failed to delete '.class_basename($model).': '.$e->getMessage())
                ->with('type', 'error');
        }
    }
}
