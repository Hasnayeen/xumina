import { useForm } from "@tanstack/react-form";
import { FormHTMLAttributes, PropsWithChildren, ReactNode } from "react";
import { renderForm } from "./render-form";
import { VariantProps } from "class-variance-authority";
import { cn } from "@/lib/utils";
import { gridColumnVariants } from "../grid-column-variants";
import { router, usePage } from "@inertiajs/react";
import { Button } from "@/xumina/components/ui/button";
import { PageProps } from "@/xumina/types/index"

type GridColumnsProps = VariantProps<typeof gridColumnVariants>

interface FormProps extends GridColumnsProps, FormHTMLAttributes<HTMLFormElement> {
  id: string,
  fields: [],
  columns: any,
  className: string,
  submitTo: string,
  submitButtonLabel: string,
  cancelButton: boolean,
  cancelButtonLabel: string,
}

export default function Form ({ id, fields, columns, className = "gap-y-0 lg:gap-y-0", submitTo, submitButtonLabel, cancelButton, cancelButtonLabel }: PropsWithChildren<FormProps>) {
  const values: [] = extractDefaultValues(fields)
  const { flash: { oldInput } } = usePage<PageProps>().props
  const form = useForm({
    defaultValues: oldInput ?? values,
    onSubmit: async ({ value }: Record<string, {}>) => {
      router.post(submitTo, value)
    }
  })
  const handleClick = () => {
    history.back()
  }

  const components = fields.map((field): ReactNode => renderForm(field, form))

  return (
    <form
      onSubmit={(e) => {
        e.preventDefault()
        e.stopPropagation()
        form.handleSubmit()
      }}
      className={cn(gridColumnVariants({ columns, className }))}
    >
      {components}
      <div className="col-start-1 space-x-4 py-4">
        <Button type="submit">
          {submitButtonLabel}
        </Button>
        {cancelButton &&
          <Button variant="outline" onClick={handleClick}>
            {cancelButtonLabel}
          </Button>
        }
      </div>
    </form>
  )
}

function extractDefaultValues (fields: any[]): [] {
  return fields.reduce((acc, current) => {
    if (current.type !== 'Field' && current.data.items) {
      return Object.assign(acc, extractDefaultValues(current.data.items));
    }
    acc[current.data.attributes.name] = current.data.attributes.value
    return acc;
  }, {});
}
