import { Link } from "@inertiajs/react"
import { useQuery } from "@tanstack/react-query";
import { PropsWithChildren } from "react"
import Navigation from "./navigation"
import Notification from "./notification";

export default function SideBar ({ logo }: PropsWithChildren<{ logo: { path: string, text: string } }>) {
  return (
    <aside className="inset-y fixed left-0 z-20 h-full flex-col border-r w-64 hidden md:flex bg-muted/40">
      <div className="flex h-full max-h-screen flex-col gap-2">
        <div className="flex h-14 items-center border-b px-4 lg:h-[60px] lg:px-6">
          <Link href="/" className="flex items-center gap-2 font-semibold">
            {logo.path &&
              <img src={logo.path} alt="logo" />
            }
            {logo.text &&
              <span className="">{logo.text}</span>
            }
          </Link>
          <Notification />
        </div>
        <div className="flex-1">
          <Navigation name="primary" className="grid items-start px-2 text-sm font-medium" />
        </div>
      </div>
    </aside>
  )
}
