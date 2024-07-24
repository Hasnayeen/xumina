<?php

namespace Hasnayeen\Xumina\Components\Concerns;

use Closure;
use Illuminate\Database\Eloquent\Model;

trait CanDeleteResource
{
    protected ?Closure $afterCallback = null;

    public function delete(Model $model)
    {
        try {
            $model->delete();

            if ($this->afterCallback) {
                call_user_func($this->afterCallback);
            }

            return redirect()
                ->route(static::getResource()::getNavigationRouteName())
                ->with('message', class_basename($model).' deleted successfully')
                ->with('type', 'success');
        } catch (\Exception $e) {
            return back()
                ->with('message', 'Failed to delete '.class_basename($model).': '.$e->getMessage())
                ->with('type', 'error');
        }
    }

    public function after(Closure $callback): static
    {
        $this->afterCallback = $callback;

        return $this;
    }
}
