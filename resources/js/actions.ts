import { router } from "@inertiajs/react";

export const deleteResource = ({
  url,
  options = {},
}: {
  url: string;
  options: {};
}) => {
  router.delete(url, options);
};
