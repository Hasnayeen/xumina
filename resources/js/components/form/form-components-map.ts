import Section from "../ui/section"
import Field from "./field"

type FormComponentList =
  | 'Field'
  | 'Section'

export interface FormComponent {
  id: string
  type: FormComponentList
  data: {
    embeddedView?: FormComponent
    items?: Array<FormComponent>
    attributes?: []
    [key: string]: unknown
  }
}

export const FormComponents = {
  Field,
  Section,
}
