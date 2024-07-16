import { Button } from "./ui/button"
import { Card } from "./ui/card"
import Form from "./form"
import Table from "./table";
import Section from "./ui/section";

type ComponentList =
  | 'Button'
  | 'Form'
  | 'Card'
  | 'Table'
  | 'Section'

export interface Component {
  id: string;
  type: ComponentList
  data: {
    embeddedView?: Component
    items?: Array<Component>
    [key: string]: unknown
  }
}

export const Components = {
  Button,
  Form,
  Card,
  Table,
  Section,
}
