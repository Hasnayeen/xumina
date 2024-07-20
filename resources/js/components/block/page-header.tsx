import { ChevronLeft } from "lucide-react";
import { Badge } from "../ui/badge";
import { Button } from "../ui/button";
import ActionContainer from "./action-container";
import { usePage } from "@inertiajs/react";

export default function PageHeader ({ ...props }) {
  const title = usePage().props.title as string
  const handleClick = () => {
    history.back()
  }
  return (
    <div className="flex items-center gap-4 pt-4 lg:pt-0">
      <Button variant="outline" size="icon" className="h-7 w-7" onClick={handleClick}>
        <ChevronLeft className="h-4 w-4" />
        <span className="sr-only">Back</span>
      </Button>
      <h1 className="flex-1 shrink-0 whitespace-nowrap text-xl font-semibold tracking-tight sm:grow-0">
        {title}
      </h1>
      <ActionContainer actions={props.actions} />
    </div>
  )
}
