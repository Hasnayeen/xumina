import React from 'react';
import { FormComponent, FormComponents } from './form-components-map';
import { FormApi } from '@tanstack/react-form';

export function renderForm (data?: FormComponent, form?: FormApi<[]>): React.ReactNode {
  if (!data) return null;

  function createForm (item: FormComponent, form: FormApi<[]> | undefined): React.ReactNode {
    const { data, type, id } = item;
    const { items, embeddedView, ...rest } = data;
    return React.createElement(
      FormComponents[type] as any,
      {
        ...rest,
        form: form,
        id,
        key: id,
      },
      Array.isArray(items)
        ? items.map(item => renderer(item, form))
        : renderer(embeddedView ?? null, form),
    );
  }

  function renderer (
    config: FormComponent | null,
    form: FormApi<[]> | undefined,
  ): React.ReactNode {
    if (!config) return null;

    return createForm(config, form);
  }

  return renderer(data, form);
}
