import { PropsWithChildren } from "react";
import { BadgeProps, Badge as BadgeUI, badgeVariants } from "./ui/badge"

export default function Badge ({ label, variant = "default" }: { label: string, variant: any }) {
  return (
    <BadgeUI variant={variant}>
      {label}
    </BadgeUI>
  )
}
