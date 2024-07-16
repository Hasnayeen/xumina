import { Link } from "@inertiajs/react"
import NavItem from "./nav-item"
import { PropsWithChildren, ReactNode } from "react"
import { useQuery } from "@tanstack/react-query"

export interface Link {
  label: string
  url: string
  icon?: any
  active?: boolean
  badge?: string
  order: number
}

interface NavigationData {
  [key: string]: {
    [key: string]: Link
  }
}

export default function Navigation ({ name, className }: PropsWithChildren<{ name: string, className: string }>) {
  const { data: navigation } = useQuery<NavigationData>({ queryKey: ['navigation'] });
  const currentNavigation = navigation ? navigation[name] : {};

  return (
    <nav className={className}>
      {(Object.entries(currentNavigation))
        .sort(([, a], [, b]) => a.order - b.order)
        .map(([key, link]): ReactNode => (
          <NavItem key={key} item={link} />
        ))}
    </nav>
  )
}

