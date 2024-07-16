import { PageProps } from "@/xumina/types";
import GuestLayout from "@/xumina/layouts/guest-layout"
import { useSetQueryData } from "@/xumina/queries/page-queries";

export default function Register ({ ...props }: PageProps<{ title: string }>) {
  useSetQueryData()

  return (
    <GuestLayout {...props} />
  )
}
