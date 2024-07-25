import React from 'react';
import { Button } from './ui/button';
import { Link } from '@inertiajs/react';
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from './ui/alert-dialog';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from './ui/dialog';
import { renderComponent } from './render-component';
import { cn } from '@/lib/utils';

type Variant = 'default' | 'destructive' | 'outline' | 'secondary' | 'ghost' | 'link';
type SizeVariant = 'default' | 'sm' | 'lg' | 'icon';

interface ActionProps {
  id: string | number;
  type: 'Action';
  data: {
    url?: string;
    label: string;
    variant?: Variant;
    asButton?: boolean;
    size?: SizeVariant;
    class?: string;
    actionType: 'url' | 'confirmationDialog' | 'dialog' | 'emitEvent';
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
  };
}

const Action: React.FC<ActionProps> = ({ id, data }) => {
  const { url, label, variant = 'default', asButton, size = 'default', class: className, actionType, confirmationDialog, dialog, action } = data;

  const isLink = !!url;

  const handleClick = (e: React.MouseEvent) => {
    if (actionType === 'emitEvent' && action) {
      e.preventDefault();
      window.dispatchEvent(new CustomEvent(action));
    }
  };

  const commonProps = {
    href: url,
    variant: variant as Variant,
    size: size as SizeVariant,
    className: cn(className, { 'inline-flex items-center justify-center': asButton && isLink }),
    onClick: handleClick,
  };

  const ActionComponent = isLink && url
    ? React.forwardRef<HTMLAnchorElement, React.AnchorHTMLAttributes<HTMLAnchorElement>>((props, ref) => (
      <Link {...props} ref={ref} />
    ))
    : Button;

  const actionElement = asButton ? (
    <Button asChild={isLink} {...commonProps}>
      {isLink ? <Link href={url}>{label}</Link> : label}
    </Button>
  ) : (
    <ActionComponent {...commonProps}>{label}</ActionComponent>
  );

  switch (actionType) {
    case 'url':
      return actionElement;

    case 'confirmationDialog':
      return (
        <AlertDialog>
          <AlertDialogTrigger asChild>
            {actionElement}
          </AlertDialogTrigger>
          <AlertDialogContent>
            <AlertDialogHeader>
              <AlertDialogTitle>{confirmationDialog?.title}</AlertDialogTitle>
              <AlertDialogDescription>
                {confirmationDialog?.description}
              </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
              <AlertDialogCancel>{confirmationDialog?.cancelLabel}</AlertDialogCancel>
              <AlertDialogAction asChild>
                {actionElement}
              </AlertDialogAction>
            </AlertDialogFooter>
          </AlertDialogContent>
        </AlertDialog>
      );

    case 'dialog':
      return (
        <Dialog>
          <DialogTrigger asChild>
            {actionElement}
          </DialogTrigger>
          <DialogContent>
            <DialogHeader>
              {dialog?.title && <DialogTitle>{dialog.title}</DialogTitle>}
              {dialog?.description && <DialogDescription>{dialog.description}</DialogDescription>}
            </DialogHeader>
            {dialog?.content.map((component, index) => renderComponent(component))}
            <DialogFooter>
              {dialog?.footer.map((component, index) => renderComponent(component))}
            </DialogFooter>
          </DialogContent>
        </Dialog>
      );

    case 'emitEvent':
      return actionElement;

    default:
      return null;
  }
};

export default Action;
