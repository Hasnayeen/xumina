import { Button } from "./button";
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from "./card";
import { FormApi } from "@tanstack/react-form";
import { PropsWithChildren } from "react";
import { gridColumnVariants } from "../grid-column-variants";
import { VariantProps } from "class-variance-authority";
import { cn } from "@/lib/utils";

type GridColumnsProps = VariantProps<typeof gridColumnVariants>

interface SectionProps extends GridColumnsProps, PropsWithChildren {
  id: string,
  form: FormApi<[]>,
  items: [],
  title?: string,
  description?: string,
  columns?: any,
  className?: string,
}

export default function Section ({ form, columns, className = "py-4 lg:py-6", ...props }: SectionProps) {
  const { children } = props
  const header = props.title || props.description
  const footer = null

  return (
    <section className={className}>
      <Card>
        {header &&
          <CardHeader>
            {props.title &&
              <CardTitle>{props.title}</CardTitle>
            }
            {props.description &&
              <CardDescription>{props.description}</CardDescription>
            }
          </CardHeader>
        }
        <CardContent className={cn(gridColumnVariants({ columns, className: header || 'pt-4' }))}>
          {children}
        </CardContent>
        {footer &&
          <CardFooter>
            <Button>Submit</Button>
          </CardFooter>
        }
      </Card>
    </section>
  )
}
