import { PageProps } from "@/xumina/types";
import AuthenticatedLayout from "@/xumina/layouts/authenticated-layout"
import { useSetQueryData } from "@/xumina/queries/page-queries";

export default function List ({ ...props }: PageProps<{ title: string }>) {
  useSetQueryData()

  return (
    <AuthenticatedLayout {...props} />
  )
}
