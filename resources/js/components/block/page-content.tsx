import Breadcrumb from "./breadcrumb"
import PageHeader from "./page-header"
import Content from "./content"

export default function PageContent () {
  return (
    <div className="flex flex-1 flex-col gap-4 px-4 lg:gap-6 lg:px-6 py-4">
      <Breadcrumb />
      <PageHeader />
      <Content />
    </div>
  )
}
