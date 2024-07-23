import Breadcrumb from "./block/breadcrumb";
import PageHeader from "./block/page-header";
import Content from "./block/content";
import Container from "./block/container";
import UserMenu from "./block/user-menu";
import { Button } from "./ui/button"
import { Card } from "./ui/card"
import Form from "./form"
import Table from "./table"
import Section from "./ui/section"
import Badge from "./badge"
import Search from "./block/search";
import ThemeSwitcher from "./block/theme-switcher";
import MobileNavigation from "./block/mobile-navigation";
import Logo from "./block/logo";
import Notification from "./block/notification";
import Navigation from "./block/navigation";

type ComponentList =
  | 'Container'
  | 'Breadcrumb'
  | 'PageHeader'
  | 'Content'
  | 'UserMenu'
  | 'Search'
  | 'ThemeSwitcher'
  | 'MobileNavigation'
  | 'Logo'
  | 'Notification'
  | 'Navigation'
  | 'Button'
  | 'Form'
  | 'Card'
  | 'Table'
  | 'Section'
  | 'Badge'

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
  Container,
  Breadcrumb,
  PageHeader,
  Content,
  UserMenu,
  Search,
  ThemeSwitcher,
  MobileNavigation,
  Logo,
  Notification,
  Navigation,
  Button,
  Form,
  Card,
  Table,
  Section,
  Badge,
}
