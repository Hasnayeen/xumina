<?php

namespace Hasnayeen\Xumina\Components\Form\Concerns;

use Hasnayeen\Xumina\Components\Form;
use Hasnayeen\Xumina\Enums\ComponentType;
use Hasnayeen\Xumina\Exceptions\ComponentNotFound;
use Hasnayeen\Xumina\Pages\CreatePage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

trait HasForm
{
    public function getFormByName(string $name): ?Form
    {
        $form = collect($this->outline())
            ->first(function ($component) use ($name) {
                return $component instanceof Form && $component->getName() === $name;
            });

        if ($form) {
            return $form;
        }

        throw new ComponentNotFound(ComponentType::Form, $name);
    }

    public function save(array $data, string $formName, ?Model $model = null)
    {
        $model = $model ?? $this->getModel();
        if (! $model) {
            throw new \Exception("Model not specified for form {$formName}");
        }

        $form = $this->getFormByName($formName);
        $fillableData = $form->getFillableData($data);

        DB::beginTransaction();

        try {
            $validatedData = $form->validate($fillableData);

            $model->fill($validatedData);
            $model->save();

            DB::commit();

            return redirect()
                ->route($form->getRedirectTo())
                ->with('message', class_basename($model).(is_subclass_of($this, CreatePage::class) ? ' created successfully' : ' updated successfully'))
                ->with('type', 'success');
        } catch (ValidationException $e) {
            DB::rollBack();

            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            throw $e;
        }
    }
}
