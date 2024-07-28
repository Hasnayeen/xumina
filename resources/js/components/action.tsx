import { forwardRef } from "react";
import { Button } from "./ui/button";
import { Link } from "@inertiajs/react";
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from "./ui/alert-dialog";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "./ui/dialog";
import { renderComponent } from "./render-component";
import { cn } from "@/lib/utils";
import { actions } from "@/actions";

type Variant =
  | "default"
  | "destructive"
  | "outline"
  | "secondary"
  | "ghost"
  | "link";
type SizeVariant = "default" | "sm" | "lg" | "icon";

interface ActionProps {
  id: string | number;
  type: "Action";
  data: {
    url?: string;
    label: string;
    variant?: Variant;
    asButton?: boolean;
    size?: SizeVariant;
    class?: string;
    actionType:
      | "url"
      | "confirmationDialog"
      | "dialog"
      | "emitEvent"
      | "customAction";
    confirmationDialog?: {
      title: string;
      description: string;
      confirmLabel: string;
      cancelLabel: string;
    };
    dialog?: {
      title?: string;
      description?: string;
      content: any[];
      footer: any[];
    };
    action?: string;
    actionData?: any;
    customAction: boolean;
    event?: string;
    icon?: string;
    iconPosition?: "left" | "right";
  };
}

const Action: React.FC<ActionProps> = ({ id, data }) => {
  const {
    url,
    label,
    variant = "default",
    asButton,
    size = "default",
    class: className,
    actionType,
    confirmationDialog,
    dialog,
    action,
    actionData,
    customAction,
    event,
    icon,
    iconPosition,
  } = data;

  const isLink = !!url;

  const handleClick = (e: React.MouseEvent) => {
    if (actionType === "emitEvent" && action) {
      e.preventDefault();
      window.dispatchEvent(new CustomEvent(action));
    }
    if (customAction && action) {
      if (typeof actions[action] === "function") {
        actions[action](actionData);
      } else {
        console.warn(
          `Action "${action}" not found in package or user actions.`,
        );
      }
    }
  };

  const props = {
    href: url || "#",
    className: cn(className, {
      "inline-flex items-center justify-center": asButton && isLink,
    }),
    onClick: handleClick,
  };

  type ActionComponentProps = {
    children: React.ReactNode;
  };

  const ActionComponent = forwardRef<HTMLDivElement, ActionComponentProps>(
    ({ children }, ref) => {
      if (isLink) {
        return (
          <Link {...props} ref={ref}>
            {children}
          </Link>
        );
      } else {
        return (
          <Button
            size={size ?? "default"}
            variant={variant ?? "default"}
            {...props}
          >
            {children}
          </Button>
        );
      }
    },
  );

  const actionElement = (
    <ActionComponent>
      {icon && iconPosition === "left" && (
        <span
          dangerouslySetInnerHTML={{ __html: icon }}
          aria-hidden="true"
          className="mr-2 h-4 w-4"
        />
      )}
      {label}
      {icon && iconPosition === "right" && (
        <span
          dangerouslySetInnerHTML={{ __html: icon }}
          aria-hidden="true"
          className="ml-2 h-4 w-4"
        />
      )}
    </ActionComponent>
  );

  const triggerElement = (
    <Button variant={variant ?? "default"} size={size ?? "default"}>
      {icon && iconPosition === "left" && (
        <span
          dangerouslySetInnerHTML={{ __html: icon }}
          aria-hidden="true"
          className="mr-2 h-4 w-4"
        />
      )}
      {label}
      {icon && iconPosition === "right" && (
        <span
          dangerouslySetInnerHTML={{ __html: icon }}
          aria-hidden="true"
          className="ml-2 h-4 w-4"
        />
      )}
    </Button>
  );

  switch (actionType) {
    case "confirmationDialog":
      return (
        <AlertDialog>
          <AlertDialogTrigger asChild>{triggerElement}</AlertDialogTrigger>
          <AlertDialogContent>
            <AlertDialogHeader>
              <AlertDialogTitle>{confirmationDialog?.title}</AlertDialogTitle>
              <AlertDialogDescription>
                {confirmationDialog?.description}
              </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
              <AlertDialogCancel>
                {confirmationDialog?.cancelLabel}
              </AlertDialogCancel>
              <AlertDialogAction asChild>{actionElement}</AlertDialogAction>
            </AlertDialogFooter>
          </AlertDialogContent>
        </AlertDialog>
      );

    case "dialog":
      return (
        <Dialog>
          <DialogTrigger asChild>{triggerElement}</DialogTrigger>
          <DialogContent>
            <DialogHeader>
              {dialog?.title && <DialogTitle>{dialog.title}</DialogTitle>}
              {dialog?.description && (
                <DialogDescription>{dialog.description}</DialogDescription>
              )}
            </DialogHeader>
            {dialog?.content.map((component, index) =>
              renderComponent(component),
            )}
            <DialogFooter>
              {dialog?.footer.map((component, index) =>
                renderComponent(component),
              )}
            </DialogFooter>
          </DialogContent>
        </Dialog>
      );

    case "url":
    case "emitEvent":
    default:
      return actionElement;
  }
};

export default Action;
