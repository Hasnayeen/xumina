import React from 'react'
import { Link } from "@inertiajs/react"
import { CircleUser } from "lucide-react"
import { Button } from "../ui/button"
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel as Label,
  DropdownMenuSeparator as Separator,
  DropdownMenuTrigger,
  DropdownMenuLabel,
} from "../ui/dropdown-menu"
import { Action } from '../table/action-dropdown'

type ComponentList =
  | 'Label'
  | 'Separator'
  | 'Action'

const Components = {
  Label,
  Separator,
}

interface Component {
  id: string
  type: ComponentList
  data: any
}

interface UserMenuProp {
  content: [],
  trigger: boolean,
  triggerVariant: "link" | "default" | "outline" | "secondary" | "destructive" | "ghost",
  triggerSize: "default" | "sm" | "lg" | "icon",
}

export default function UserMenu ({ content, trigger, triggerVariant, triggerSize }: UserMenuProp) {
  const children = content?.map((component: Component): React.ReactNode => {
    const { data, type, id } = component;
    const { ...rest } = data
    if (type === 'Action') {
      const action = data as Action
      const handleAction = (action: Action) => {
        if (action.action) {
          const fn = new Function(action.action);
          fn();
        }
      }
      if (action.url) {
        return (
          <DropdownMenuItem key={action.label} asChild>
            <Link href={action.url} className="flex items-center">
              {action.icon && (
                <span
                  dangerouslySetInnerHTML={{ __html: action.icon }}
                  aria-hidden="true"
                  className="mr-2 h-4 w-4"
                />
              )}
              {action.label}
            </Link>
          </DropdownMenuItem>
        );
      } else {
        return (
          <DropdownMenuItem key={action.label} onSelect={() => handleAction(action)}>
            {action.icon && (
              <span
                dangerouslySetInnerHTML={{ __html: action.icon }}
                aria-hidden="true"
                className="mr-2 h-4 w-4"
              />
            )}
            {action.label}
          </DropdownMenuItem>
        );
      }
    }
    if (type === 'Label') {
      return (
        <DropdownMenuLabel key={id}>{data.body}</DropdownMenuLabel>
      )
    }
    return React.createElement(
      Components[type] as any,
      {
        ...rest,
        id,
        key: id,
      },
    );
  })

  return (
    <DropdownMenu>
      <DropdownMenuTrigger asChild>
        <Button variant={triggerVariant} size={triggerSize}>
          <CircleUser className="h-5 w-5" />
          <span className="sr-only">Toggle user menu</span>
        </Button>
      </DropdownMenuTrigger>
      <DropdownMenuContent align="end">
        {children}
      </DropdownMenuContent>
    </DropdownMenu>
  )
}
