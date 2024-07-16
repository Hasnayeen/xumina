export default function Container ({ className, children }: { className: string, children: [] }) {
  return (
    <div className={className}>
      {children}
    </div>
  )
}
