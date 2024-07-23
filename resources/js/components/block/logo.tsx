import { PropsWithChildren } from "react"
import { Link } from "@inertiajs/react"

export default function Logo ({ logo }: PropsWithChildren<{ logo: { path: string, text: string } }>) {
  return (
    <Link href="/" className="flex items-center gap-2 font-semibold">
      {logo.path &&
        <img src={logo.path} alt="logo" />
      }
      {logo.text &&
        <span className="">{logo.text}</span>
      }
    </Link>
  )
}
