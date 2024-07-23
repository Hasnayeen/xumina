import React, { useState } from 'react';
import { Button } from "../ui/button";
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from "../ui/sheet";
import { Bell } from "lucide-react";

interface NotificationProp {
  trigger: boolean,
  triggerVariant: "link" | "default" | "outline" | "secondary" | "destructive" | "ghost",
  triggerSize: "default" | "sm" | "lg" | "icon",
}

export default function Notification ({ trigger, triggerVariant, triggerSize }: NotificationProp) {
  const [open, setOpen] = useState(false);

  return (
    <Sheet open={open} onOpenChange={setOpen}>
      <SheetTrigger asChild>
        <Button variant={triggerVariant} size={triggerSize}>
          <Bell className="h-4 w-4" />
          <span className="sr-only">Toggle notifications</span>
        </Button>
      </SheetTrigger>
      <SheetContent>
        <SheetHeader>
          <SheetTitle>Notifications</SheetTitle>
        </SheetHeader>
        {/* Add your notification content here */}
        <div className="py-4">
          <p>Your notifications will appear here.</p>
        </div>
      </SheetContent>
    </Sheet>
  )
}
