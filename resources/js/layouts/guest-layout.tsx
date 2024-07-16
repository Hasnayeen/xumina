import { ReactNode } from "react"
import { Head } from '@inertiajs/react';
import { Block } from "@/xumina/components/blocks-map"
import { renderBlock } from "@/xumina/components/block/render-block";
import { PageProps } from "@/xumina/types";
import { useQuery } from "@tanstack/react-query"

export default function GuestLayout ({ data, ...props }: PageProps<{ data: {}, title: string }>) {
  const { data: layout } = useQuery<[]>({ queryKey: ['layout'] })
  const blocks = layout?.map((block: Block): ReactNode => renderBlock(block))

  return (
    <>
      <Head title={props.title} />
      {blocks}
    </>
  )
}
