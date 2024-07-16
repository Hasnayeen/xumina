import { cva } from "class-variance-authority";

export const gridColumnVariants = cva(
  "grid gap-4 lg:gap-6",
  {
    variants: {
      columns: {
        1: "grid-cols-1",
        2: "grid-cols-2",
        3: "grid-cols-3",
        4: "grid-cols-4",
        5: "grid-cols-5",
        6: "grid-cols-6",
        7: "grid-cols-7",
        8: "grid-cols-8",
        9: "grid-cols-9",
        10: "grid-cols-10",
        11: "grid-cols-11",
        12: "grid-cols-12",
      },
    },
    defaultVariants: {
      columns: 1,
    },
  }
)
