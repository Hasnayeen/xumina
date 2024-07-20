import { PropsWithChildren } from "react"
import { Button } from "../ui/button"
import { Checkbox } from "../ui/checkbox"
import { ColumnDef } from "@tanstack/react-table"
import { ArrowUpDown } from "lucide-react"
import ActionDropdown, { Action } from "./action-dropdown"
import DataTable, { PaginatedData } from "./data-table"
import { useQuery } from "@tanstack/react-query";
import { get } from 'lodash'

interface TableProps {
  id: string,
  columns: [],
  tabelSpec: {},
  model: string,
  actions: Action[],
  globalSort: boolean,
  globalSearch: boolean,
  pagination: {},
  pageSizeOptions?: (number | string)[],
}

export default function Table ({ id, columns, model, tabelSpec, actions, globalSort = false, globalSearch, pagination, pageSizeOptions }: PropsWithChildren<TableProps>) {
  type Model = typeof tabelSpec

  const dataQuery = () => {
    return useQuery({
      queryKey: [model, 'list'],
      initialData: pagination,
      queryFn: () => pagination,
    })
  }

  const { data, error } = dataQuery()

  const cols = columns.map(({ data }) => {
    const { name, header, footer, sortable, searchable } = data
    return {
      accessorKey: name,
      enableSorting: sortable,
      enableGlobalFilter: searchable,
      header: ({ column }: any) => {
        if (!header) return null
        if (globalSort) return header
        if (sortable) {
          return (
            <Button
              className="px-0"
              variant="ghost"
              onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}
            >
              {header}
              <ArrowUpDown className="ml-2 h-4 w-4" />
            </Button>
          )
        }
        return header
      },
      footer: footer ?? null,
      cell: ({ row }: any) => {
        const value = get(row.original, name);
        return <div>{value}</div>;
      }
    }
  })

  const tableSpec: ColumnDef<Model>[] = [
    {
      id: "select",
      size: 20,
      header: ({ table }) => (
        <Checkbox
          className="flex justify-center"
          checked={
            table.getIsAllPageRowsSelected() ||
            (table.getIsSomePageRowsSelected() && "indeterminate")
          }
          onCheckedChange={(value) => table.toggleAllPageRowsSelected(!!value)}
          aria-label="Select all"
        />
      ),
      cell: ({ row }) => (
        <Checkbox
          className="flex justify-center"
          checked={row.getIsSelected()}
          onCheckedChange={(value) => row.toggleSelected(!!value)}
          aria-label="Select row"
        />
      ),
      enableSorting: false,
      enableHiding: false,
    },
    ...cols,
    {
      id: "actions",
      enableHiding: false,
      size: 20,
      cell: ({ row }) => {
        if (actions.length > 0) {
          return (
            <ActionDropdown actions={actions} rowData={row.original} />
          )
        }
      },
    },
  ]

  return (
    <div className="">
      <DataTable
        columns={tableSpec}
        globalSort={globalSort}
        globalSearch={globalSearch}
        pagination={data as PaginatedData}
        pageSizeOptions={pageSizeOptions ?? [10, 25, 50]} />
    </div>
  )
}

