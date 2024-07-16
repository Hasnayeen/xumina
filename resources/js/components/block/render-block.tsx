import React from 'react';
import { Blocks, Block } from '../blocks-map';

export function renderBlock (data?: Block) {
  if (!data) return null;

  function createComponent (item: Block): React.ReactNode {
    const { data, type, id } = item;
    const { items, embeddedView, ...rest } = data;
    return React.createElement(
      Blocks[type] as any,
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
    config: Block | null,
  ) {
    if (!config) return null;

    return createComponent(config);
  }

  return renderer(data);
}
