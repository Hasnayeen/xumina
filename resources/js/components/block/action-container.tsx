import { Button } from "../ui/button";
import { Link } from "@inertiajs/react"
import { cva, type VariantProps } from "class-variance-authority"
import { cn } from "@/lib/utils"

const linkVariants = cva(
  "inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50",
  {
    variants: {
      variant: {
        default: "text-primary underline-offset-4 hover:underline",
        button: "bg-primary text-primary-foreground hover:bg-primary/90",
        destructive:
          "bg-destructive text-destructive-foreground hover:bg-destructive/90",
        outline:
          "border border-input bg-background hover:bg-accent hover:text-accent-foreground",
        secondary:
          "bg-secondary text-secondary-foreground hover:bg-secondary/80",
        ghost: "hover:bg-accent hover:text-accent-foreground",
      },
      size: {
        default: "h-10 px-4 py-2",
        sm: "h-9 rounded-md px-3",
        lg: "h-11 rounded-md px-8",
        icon: "h-10 w-10",
      },
    },
    defaultVariants: {
      variant: "default",
      size: "default",
    },
  }
)

type LinkVariant = "default" | "button" | "destructive" | "outline" | "secondary" | "ghost";
type ButtonVariant = "default" | "destructive" | "outline" | "secondary" | "ghost" | "link";
type SizeVariant = "default" | "sm" | "lg" | "icon";

type Action = {
  id: string | number;
  data: {
    url?: string;
    label: string;
    variant?: LinkVariant | ButtonVariant;
    asButton?: boolean;
    asLink?: boolean;
    size?: SizeVariant;
    class?: string;
  };
};

export default function ActionContainer ({ actions }: { actions: Action[] }) {
  return (
    <>
      {actions.map(({ id, data }) => (
        <div key={id} className="hidden items-center gap-2 md:ml-auto md:flex">
          {data.url ? (
            <Link
              href={data.url}
              className={cn(
                linkVariants({
                  variant: (data.variant as LinkVariant) ?? (data.asButton ? "button" : "default"),
                  size: data.size,
                  className: data.class,
                })
              )}
            >
              {data.label}
            </Link>
          ) : (
            <Button
              variant={(data.variant as ButtonVariant) ?? (data.asLink ? "link" : "default")}
              size={data.size ?? "default"}
              className={data.class}
            >
              {data.label}
            </Button>
          )}
        </div>
      ))}
    </>
  );
}

