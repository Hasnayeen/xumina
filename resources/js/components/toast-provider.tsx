import React, { useEffect } from 'react';
import { Toaster, toast } from 'sonner';
import { usePage } from '@inertiajs/react';
import { PageProps } from '@/xumina/types';

export default function ToastProvider () {
  const { flash } = usePage<PageProps>().props;

  useEffect(() => {
    if (flash.message) {
      switch (flash.type) {
        case 'success':
          toast.success(flash.message);
          break;
        case 'error':
          toast.error(flash.message);
          break;
        default:
          toast(flash.message);
      }
    }
  }, [flash]);

  return <Toaster />;
}
