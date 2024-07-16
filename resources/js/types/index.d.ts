import { Link } from "@/xumina/components/block/navigation";

export interface User {
  id: number;
  name: string;
  email: string;
  email_verified_at: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  auth: {
    user: User;
  };
  title: string;
  data: {
    layout: []
    content: []
    breadcrumb: []
    navigations: Record<string, Link>;
  };
  flash: {
    message?: string;
    type?: 'success' | 'error' | 'info';
    oldInput?: [],
  };
};
