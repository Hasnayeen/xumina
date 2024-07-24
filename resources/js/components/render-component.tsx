import React from 'react';
import { Components, Component } from './components-map';

export function renderComponent (data?: Component): React.ReactNode {
  if (!data) return null;

  function createComponent (item: Component): React.ReactNode {
    const { data, type, id } = item;
    const { items, ...rest } = data;
    return React.createElement(
      Components[type] as any,
      {
        ...rest,
        id,
        key: id,
      },
      Array.isArray(items) && items.map(renderer)
    );
  }

  function renderer (
    item: Component | null,
  ): React.ReactNode {
    if (!item) return null;

    return createComponent(item);
  }

  return renderer(data);
}
