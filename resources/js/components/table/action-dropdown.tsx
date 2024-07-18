import { Link } from "@inertiajs/react"
import { Button } from "../ui/button"
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from "../ui/dropdown-menu"
import { MoreHorizontal } from "lucide-react"

export interface Action {
  label: string;
  icon?: string;
  url?: string;
  action?: string;
}

interface ActionDropdownProps {
  actions: Action[];
  rowData: any;
}

export default function ActionDropdown ({ actions, rowData }: ActionDropdownProps) {
  const handleAction = (action: Action) => {
    if (action.action) {
      const fn = new Function('id', action.action);
      fn(rowData.id);
    }
  };

  return (
    <DropdownMenu>
      <DropdownMenuTrigger asChild>
        <Button variant="ghost" className="h-8 w-8 p-0">
          <span className="sr-only">Open menu</span>
          <MoreHorizontal className="h-4 w-4" />
        </Button>
      </DropdownMenuTrigger>
      <DropdownMenuContent align="end">
        <DropdownMenuItem>
          {actions.map((action) => {
            const Icon = iconMap[action.icon];
            if (action.url) {
              const url = action.url.replace(':id', rowData.id);
              return (
                <DropdownMenuItem key={action.name} asChild>
                  <Link href={url} className="flex items-center">
                    {Icon && <Icon className="mr-2 h-4 w-4" />}
                    {action.label}
                  </Link>
                </DropdownMenuItem>
              );
            } else {
              return (
                <DropdownMenuItem key={action.name} onSelect={() => handleAction(action)}>
                  {Icon && <Icon className="mr-2 h-4 w-4" />}
                  {action.label}
                </DropdownMenuItem>
              );
            }
          })}
        </DropdownMenuItem>
      </DropdownMenuContent>
    </DropdownMenu>
  )
}
