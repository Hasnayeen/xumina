import { ReactNode } from "react";
import { renderComponent } from "./../render-component";
import { Component } from "../components-map";
import { useQuery } from "@tanstack/react-query";

export default function Content () {
  const { data: content } = useQuery<[]>({ queryKey: ['content'] });
  const components = content?.map((component: Component): ReactNode => renderComponent(component))
  return (
    <main
      className="flex flex-col gap-4 lg:gap-6"
    >
      {components}
    </main>
  )
}
