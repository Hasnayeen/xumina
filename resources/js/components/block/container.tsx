export default function Container ({ tag = 'div', className, children }: { tag: string, className: string, children: [] }) {
  const Comp: any = tag;

  return (
    <Comp className={className} >
      {children}
    </Comp>
  )
}
