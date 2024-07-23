import { Menu } from "lucide-react"
import Navigation from "./navigation"
import { Button } from "../ui/button"
import { Sheet, SheetContent, SheetTrigger } from "../ui/sheet"

export default function MobileNavigation () {
  return (
    <Sheet>
      <SheetTrigger asChild>
        <Button
          variant="outline"
          size="icon"
          className="shrink-0 md:hidden"
        >
          <Menu className="h-5 w-5" />
          <span className="sr-only">Toggle navigation menu</span>
        </Button>
      </SheetTrigger>
      <SheetContent side="left" className="flex flex-col">
        <Navigation name="primary" className="pt-4 grid gap-2 text-lg font-medium" />
      </SheetContent>
    </Sheet>
  )
}
