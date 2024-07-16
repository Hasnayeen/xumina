import './bootstrap';
import '../css/app.css';

import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { ThemeProvider } from './theme-provider';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const queryClient = new QueryClient();

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => resolvePageComponent(`./pages/${name}.tsx`, import.meta.glob('./pages/**/*.tsx')),
  setup ({ el, App, props }) {
    const Wrapper = () => (
      <QueryClientProvider client={queryClient}>
        <ThemeProvider>
          <App {...props} />
        </ThemeProvider>
      </QueryClientProvider>
    )
    createRoot(el).render(<Wrapper />);
  },
  progress: {
    color: '#4B5563',
  },
});
