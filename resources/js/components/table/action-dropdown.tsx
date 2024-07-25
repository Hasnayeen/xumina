import { Link } from "@inertiajs/react"
import { Button } from "../ui/button"
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from "../ui/dropdown-menu"
import { MoreHorizontal } from "lucide-react"

export interface Action {
  id: string | number;
  data: {
    label: string;
    icon?: string;
    url?: string;
    action?: string;
    requireConfirmation: boolean;
  }
}

interface ActionDropdownProps {
  actions: Action[];
  rowData: any;
}

export default function ActionDropdown ({ actions, rowData }: ActionDropdownProps) {
  const handleAction = (action?: string) => {
    if (action) {
      const fn = new Function('id', action);
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
          {actions.map(({ id, data }) => {
            if (data.requireConfirmation) {
              return (
                <DropdownMenuItem key={id} onSelect={() => handleAction(data.action)}>
                  {data.icon && (
                    <span
                      dangerouslySetInnerHTML={{ __html: data.icon }}
                      aria-hidden="true"
                      className="mr-2 h-4 w-4"
                    />
                  )}
                  {data.label}
                </DropdownMenuItem>
              );
            }
            if (data.url) {
              const url = data.url.replace(':id', rowData.id);
              return (
                <DropdownMenuItem key={data.label} asChild>
                  <Link href={url} className="flex items-center">
                    {data.icon && (
                      <span
                        dangerouslySetInnerHTML={{ __html: data.icon }}
                        aria-hidden="true"
                        className="mr-2 h-4 w-4"
                      />
                    )}
                    {data.label}
                  </Link>
                </DropdownMenuItem>
              );
            } else {
              return (
                <DropdownMenuItem key={data.label} onSelect={() => handleAction(data.action)}>
                  {data.icon && (
                    <span
                      dangerouslySetInnerHTML={{ __html: data.icon }}
                      aria-hidden="true"
                      className="mr-2 h-4 w-4"
                    />
                  )}
                  {data.label}
                </DropdownMenuItem>
              );
            }
          })}
        </DropdownMenuItem>
      </DropdownMenuContent>
    </DropdownMenu>
  )
}
