import { ReactNode } from "react"
import { Head } from '@inertiajs/react';
import { PageProps } from "@/xumina/types";
import { useQuery } from "@tanstack/react-query"
import { renderComponent } from "@/xumina/components/render-component";
import { Component } from "@/xumina/components/components-map";

export default function GuestLayout ({ data, ...props }: PageProps<{ data: {}, title: string }>) {
  const { data: layout } = useQuery<[]>({ queryKey: ['layout'] })
  const components = layout?.map((component: Component): ReactNode => renderComponent(component))

  return (
    <>
      <Head title={props.title} />
      {components}
    </>
  )
}
