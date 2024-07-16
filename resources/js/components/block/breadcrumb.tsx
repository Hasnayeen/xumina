import {
  Breadcrumb as BreadcrumbCtn,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator,
} from "../ui/breadcrumb"
import { Link } from "@inertiajs/react"
import { Fragment } from "react"
import { useQuery } from "@tanstack/react-query"

interface BreadcrumbItem {
  text: string
  url: string
}

export default function Breadcrumb () {
  const { data: breadcrumb } = useQuery<BreadcrumbItem[]>({ queryKey: ['breadcrumb'] });

  return (
    <BreadcrumbCtn className="hidden md:flex">
      <BreadcrumbList>
        {breadcrumb?.map((link: BreadcrumbItem, index: number, { length }) => {
          return (
            <Fragment key={index}>
              <BreadcrumbItem>
                <BreadcrumbLink asChild>
                  <Link href={link.url}>{link.text}</Link>
                </BreadcrumbLink>
              </BreadcrumbItem>
              {(index + 1) === length ||
                <BreadcrumbSeparator />
              }
            </Fragment>
          )
        })
        }
      </BreadcrumbList>
    </BreadcrumbCtn>
  )
}
