import { useEffect } from 'react';
import { usePage } from '@inertiajs/react';
import { useQueryClient } from '@tanstack/react-query';
import { PageProps } from "@/xumina/types/index"
import { User } from '../types';

export function useSetQueryData () {
  const { props } = usePage<{ data: PageProps }>();
  const queryClient = useQueryClient();
  const queryMapping = {
    ['content']: 'content',
    ['navigation']: 'navigations',
    ['breadcrumb']: 'breadcrumb',
    ['layout']: 'layout',
  }

  const auth = props.auth as { user: User };
  queryClient.setQueryData(['auth', 'user'], auth.user);

  useEffect(() => {
    Object.entries(queryMapping).forEach(([queryKey, propKey]) => {
      if (props.data[propKey] !== undefined) {
        queryClient.setQueryData([queryKey], props.data[propKey]);
      }
    });
  }, [props, queryClient, queryMapping]);
}
