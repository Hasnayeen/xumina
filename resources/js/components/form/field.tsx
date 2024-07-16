import { Button } from "@/xumina/components/ui/button";
import { Checkbox } from "@/xumina/components/ui/checkbox";
import { Input } from "@/xumina/components/ui/input";
import { Label } from "@/xumina/components/ui/label";
import { Calendar } from "@/xumina/components/ui/calendar";
import { format } from "date-fns";
import { cn } from "@/lib/utils";
import { CalendarIcon } from "lucide-react";
import { Popover, PopoverContent, PopoverTrigger } from "@/xumina/components/ui/popover";
import { RadioGroup, RadioGroupItem } from "@/xumina/components/ui/radio-group";
import { Select, SelectTrigger, SelectContent, SelectItem, SelectValue } from "../ui/select";
import { Switch } from "@/xumina/components/ui/switch";
import { Textarea } from "@/xumina/components/ui/textarea";
import { usePage } from '@inertiajs/react'

interface FieldProps {
  id: string,
  form: any,
  attributes: {
    name: string,
    label: string,
    type: string,
    placeholder?: string,
    options?: Record<string, string> | Array<{ value: string; label: string }>,
    multiple?: boolean;
    checked?: boolean;
    rows?: number;
    format?: string;
    accept?: string[];
  },
}

export default function Field ({ form, attributes }: FieldProps) {
  const { errors } = usePage().props

  const normalizeOptions = (options: FieldProps['attributes']['options']) => {
    if (!options) return [];
    if (Array.isArray(options)) return options;
    return Object.entries(options).map(([value, label]) => ({ value, label }));
  };

  const renderField = (field: any) => {
    switch (attributes.type) {
      case 'select':
        const selectOptions = normalizeOptions(attributes.options);
        return (
          <Select
            name={attributes.name}
            value={String(field.state.value)}
            onValueChange={(value) => field.handleChange(value)}
          >
            <SelectTrigger>
              <SelectValue placeholder={attributes.placeholder}>
                {selectOptions.find(option => String(option.value) === String(field.state.value))?.label}
              </SelectValue>
            </SelectTrigger>
            <SelectContent>
              {selectOptions.map((option) => (
                <SelectItem key={option.value} value={option.value}>
                  {option.label}
                </SelectItem>
              ))}
            </SelectContent>
          </Select>
        );
      case 'checkbox':
        return (
          <Checkbox
            checked={field.state.value}
            onCheckedChange={field.handleChange}
          />
        );
      case 'radio':
        const radioOptions = normalizeOptions(attributes.options);
        return (
          <RadioGroup
            value={field.state.value}
            onValueChange={field.handleChange}
          >
            {radioOptions.map((option) => (
              <div key={option.value} className="flex items-center space-x-2">
                <RadioGroupItem value={option.value} id={`${attributes.name}-${option.value}`} />
                <Label htmlFor={`${attributes.name}-${option.value}`}>{option.label}</Label>
              </div>
            ))}
          </RadioGroup>
        );
      case 'datepicker':
        return (
          <Popover>
            <PopoverTrigger asChild>
              <Button
                variant={"outline"}
                className={cn(
                  "w-full justify-start text-left font-normal",
                  !field.state.value && "text-muted-foreground"
                )}
              >
                <CalendarIcon className="mr-2 h-4 w-4" />
                {field.state.value ? format(field.state.value, attributes.format || 'PPP') : <span>Pick a date</span>}
              </Button>
            </PopoverTrigger>
            <PopoverContent className="w-auto p-0">
              <Calendar
                mode="single"
                selected={field.state.value}
                onSelect={field.handleChange}
                initialFocus
              />
            </PopoverContent>
          </Popover>
        );
      case 'fileupload':
        return (
          <Input
            type="file"
            name={attributes.name}
            accept={attributes.accept?.join(',')}
            multiple={attributes.multiple}
            onChange={(e) => field.handleChange(e.target.files)}
          />
        );
      case 'switch':
        return (
          <div className="w-full h-10 flex items-center">
            <Switch
              checked={field.state.value}
              onCheckedChange={field.handleChange}
            />
          </div>
        );
      case 'textarea':
        return (
          <Textarea
            name={attributes.name}
            placeholder={attributes.placeholder}
            value={field.state.value}
            rows={attributes.rows || 3}
            onChange={(e) => field.handleChange(e.target.value)}
          />
        );
      default:
        return (
          <Input
            name={attributes.name}
            type={attributes.type}
            placeholder={attributes.placeholder}
            value={field.state.value}
            onBlur={field.handleBlur}
            onChange={(e) => field.handleChange(e.target.value)}
          />
        );
    }
  };

  return (
    <form.Field
      key={attributes.name}
      name={attributes.name}
    >
      {(field: any) => (
        <div className="py-2">
          <Label htmlFor={attributes.name}>{attributes.label}</Label>
          {renderField(field)}
          {errors[attributes.name] && <p className="text-red-500 text-sm mt-1">{errors[attributes.name]}</p>}
        </div>
      )}
    </form.Field>
  )
}
