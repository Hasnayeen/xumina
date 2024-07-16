import {
  ColumnDef,
  ColumnFiltersState,
  GlobalFilterTableState,
  SortingState,
  VisibilityState,
  flexRender,
  getCoreRowModel,
  getFilteredRowModel,
  getPaginationRowModel,
  getSortedRowModel,
  useReactTable,
} from "@tanstack/react-table"

import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "../ui/table"
import React from "react"
import { Button } from "../ui/button"
import { DropdownMenu, DropdownMenuCheckboxItem, DropdownMenuContent, DropdownMenuRadioGroup, DropdownMenuRadioItem, DropdownMenuTrigger } from "../ui/dropdown-menu"
import { ArrowUpDownIcon, Settings2 } from "lucide-react"
import { Input } from "../ui/input"
import Pagination from "./pagination"

export interface PaginatedData {
  data: any[],
  total: number,
}

interface DataTableProps<TData, TValue> {
  columns: ColumnDef<TData, TValue>[]
  globalSort: boolean,
  globalSearch: boolean,
  pagination: PaginatedData,
  pageSizeOptions: (number | string)[],
}

export default function DataTable<TData, TValue> ({ columns, globalSort, globalSearch, pagination, pageSizeOptions }: DataTableProps<TData, TValue>) {
  const { data, total } = pagination
  const [sorting, setSorting] = React.useState<SortingState>([])
  const [columnFilters, setColumnFilters] = React.useState<ColumnFiltersState>([])
  const [columnVisibility, setColumnVisibility] = React.useState<VisibilityState>({})
  const [rowSelection, setRowSelection] = React.useState({})
  const [globalFilter, setGlobalFilter] = React.useState('')

  const table = useReactTable({
    data,
    columns,
    onSortingChange: setSorting,
    onColumnFiltersChange: setColumnFilters,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    onColumnVisibilityChange: setColumnVisibility,
    onRowSelectionChange: setRowSelection,
    state: {
      sorting,
      columnFilters,
      columnVisibility,
      rowSelection,
      globalFilter,
    },
    enableGlobalFilter: globalSearch,
    onGlobalFilterChange: setGlobalFilter,
    globalFilterFn: 'includesString',
  })

  return (
    <div className="w-full">
      <div className="flex justify-between items-center py-4">
        <div>
          {globalSearch &&
            <Input
              placeholder="Search ..."
              value={globalFilter ?? ""}
              onChange={(event) =>
                setGlobalFilter(event.target.value)
              }
              className="max-w-sm"
            />
          }
        </div>
        <div className="flex space-x-4">
          {globalSort &&
            <DropdownMenu>
              <DropdownMenuTrigger asChild>
                <Button variant="outline" className="ml-auto shrink-0">
                  <ArrowUpDownIcon className="w-4 h-4 mr-2" />
                  Sort by
                </Button>
              </DropdownMenuTrigger>
              {/*
              <DropdownMenuContent className="w-[200px]" align="end">
                <DropdownMenuRadioGroup value={sorting?.id} onValueChange={(id) => table.getColumn(id)?.toggleSorting()}>
                  {table
                    .getAllColumns()
                    .filter((column) => column.getCanSort())
                    .map((column) => {
                      return (
                        <DropdownMenuRadioItem
                          value={column.id}
                          key={column.id}
                          className="capitalize"
                        >
                          {column.id}{" "}
                          {sorting[0]?.id === column.id && (sorting[0]?.desc ? ' 🔽' : ' 🔼')}
                        </DropdownMenuRadioItem >
                      )
                    })}
                </DropdownMenuRadioGroup>
              </DropdownMenuContent>
              */}
            </DropdownMenu>
          }
          <DropdownMenu>
            <DropdownMenuTrigger asChild>
              <Button variant="outline" className="ml-auto">
                <Settings2 className="mr-2 h-4 w-4" /> Columns
              </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
              {table
                .getAllColumns()
                .filter((column) => column.getCanHide())
                .map((column) => {
                  return (
                    <DropdownMenuCheckboxItem
                      key={column.id}
                      className="capitalize"
                      checked={column.getIsVisible()}
                      onCheckedChange={(value) =>
                        column.toggleVisibility(!!value)
                      }
                    >
                      {column.id}
                    </DropdownMenuCheckboxItem>
                  )
                })}
            </DropdownMenuContent>
          </DropdownMenu>
        </div>
      </div>
      <div className="rounded-md border">
        <Table>
          <TableHeader>
            {table.getHeaderGroups().map((headerGroup) => (
              <TableRow key={headerGroup.id}>
                {headerGroup.headers.map((header) => {
                  return (
                    <TableHead key={header.id} className={(header.getSize() === 20) ? 'w-16' : ''}>
                      {header.isPlaceholder
                        ? null
                        : flexRender(
                          header.column.columnDef.header,
                          header.getContext()
                        )}
                    </TableHead>
                  )
                })}
              </TableRow>
            ))}
          </TableHeader>
          <TableBody>
            {table.getRowModel().rows?.length ? (
              table.getRowModel().rows.map((row) => (
                <TableRow
                  key={row.id}
                  data-state={row.getIsSelected() && "selected"}
                >
                  {row.getVisibleCells().map((cell) => (
                    <TableCell key={cell.id}>
                      {flexRender(
                        cell.column.columnDef.cell,
                        cell.getContext()
                      )}
                    </TableCell>
                  ))}
                </TableRow>
              ))
            ) : (
              <TableRow>
                <TableCell
                  colSpan={columns.length}
                  className="h-24 text-center"
                >
                  No results.
                </TableCell>
              </TableRow>
            )}
          </TableBody>
        </Table>
      </div>
      <Pagination table={table} total={total} pageSizeOptions={pageSizeOptions} />
    </div>
  )
}
