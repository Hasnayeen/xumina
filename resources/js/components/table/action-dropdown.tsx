import { Link } from "@inertiajs/react";
import { Button } from "../ui/button";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "../ui/dropdown-menu";
import { MoreHorizontal } from "lucide-react";
import Action from "../action";
import { ActionProps as ActionType } from "../action";

interface ActionDropdownProps {
  actions: ActionType[];
  rowData: any;
}

export default function ActionDropdown({
  actions,
  rowData,
}: ActionDropdownProps) {
  const replaceRouteParams = (params: Record<string, any>) => {
    const newParams: Record<string, any> = {};
    for (const [key, value] of Object.entries(params)) {
      if (typeof value === "string" && value.startsWith(":")) {
        const rowDataKey = value.slice(1); // Remove the ':' prefix
        newParams[key] = rowData[rowDataKey] ?? value; // Use rowData value if it exists, otherwise keep the original
      } else {
        newParams[key] = value;
      }
    }
    return newParams;
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
        {actions.map(({ id, data }: ActionType) => (
          <DropdownMenuItem key={id}>
            <Action
              id={id}
              type="Action"
              data={{
                ...data,
                routeParams: data.routeParams
                  ? replaceRouteParams(data.routeParams)
                  : undefined,
              }}
            />
          </DropdownMenuItem>
        ))}
      </DropdownMenuContent>
    </DropdownMenu>
  );
}
