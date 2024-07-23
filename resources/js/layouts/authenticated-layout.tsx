import { ReactNode, useMemo, useRef, useEffect, useCallback } from "react"
import { Head } from '@inertiajs/react';
import { renderComponent } from "@/xumina/components/render-component";
import { PageProps } from "@/xumina/types";
import ToastProvider from "@/xumina/components/toast-provider";
import { useQuery } from "@tanstack/react-query"
import { Component } from "../components/components-map";

export default function AuthenticatedLayout ({ auth, data, ...props }: PageProps<{ auth: {}, data: {}, title: string }>) {
  const { data: layout } = useQuery<[]>({ queryKey: ['layout'] })
  const blocks = layout?.map((component: Component): ReactNode => renderComponent(component)) ?? []

  return (
    <>
      <Head title={props.title} />
      {blocks}
      <ToastProvider />
    </>
  )
}
