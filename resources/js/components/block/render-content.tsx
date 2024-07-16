import React from 'react';
import { Components, Component } from './../components-map';

export function renderContent (data?: Component): React.ReactNode {
  if (!data) return null;

  function createComponent (item: Component): React.ReactNode {
    const { data, type, id } = item;
    const { items, embeddedView, ...rest } = data;
    return React.createElement(
      Components[type] as any,
      {
        ...rest,
        id,
        key: id,
      },
      Array.isArray(items)
        ? items.map(renderer)
        : renderer(embeddedView ?? null),
    );
  }

  function renderer (
    config: Component | null,
  ): React.ReactNode {
    if (!config) return null;

    return createComponent(config);
  }

  return renderer(data);
}
