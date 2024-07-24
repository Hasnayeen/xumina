import React, { useState } from 'react'
import { Link } from "@inertiajs/react"
import { Badge } from "../ui/badge"
import { cva, type VariantProps } from "class-variance-authority"
import { cn } from "@/lib/utils"
import { ChevronDown, ChevronRight } from 'lucide-react'

const navItemVariants = cva(
  "flex items-center gap-3 rounded-lg px-3 py-2 transition-all hover:text-primary",
  {
    variants: {
      variant: {
        default: "text-muted-foreground",
        active: "bg-muted-foreground text-muted",
      }
    },
    defaultVariants: {
      variant: "default",
    },
  }
)

type BadgeVariant = "default" | "secondary" | "destructive" | "outline"

export interface NavItemProps
  extends React.HTMLAttributes<HTMLDivElement>,
  VariantProps<typeof navItemVariants> {
  item: any,
  depth?: number,
  url?: string,
  badge?: string,
  badgeVariant?: BadgeVariant,
}

export default function NavItem ({ item, depth = 0, className, badgeVariant }: NavItemProps) {
  const [isOpen, setIsOpen] = useState(false);
  const variant = item.active ? "active" : "default"

  if (item.children) {
    return (
      <div className="mb-2">
        <button
          className="flex items-center w-full text-left px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 focus:outline-none"
          onClick={() => setIsOpen(!isOpen)}
          style={{ paddingLeft: `${depth * 16 + 16}px` }}
        >
          {isOpen ? <ChevronDown className="w-4 h-4 mr-2" /> : <ChevronRight className="w-4 h-4 mr-2" />}
          {item.label}
        </button>
        {isOpen && (
          <div className="ml-4">
            {item.children.map((child: {}, index: number) => (
              <NavItem key={index} item={child} depth={depth + 1} />
            ))}
          </div>
        )}
      </div>
    );
  }

  return (
    <Link
      href={item.url ?? '#'}
      className={cn(navItemVariants({ variant }), className)}
      style={{ paddingLeft: `${depth * 16 + 16}px` }}
    >
      {item.icon && (
        <span
          dangerouslySetInnerHTML={{ __html: item.icon }}
          aria-hidden="true"
        />
      )}
      {item.label}
      {item.badge &&
        <Badge variant={badgeVariant} className="ml-auto flex h-6 w-6 shrink-0 items-center justify-center rounded-full">
          {item.badge}
        </Badge>
      }
    </Link>
  );
}
