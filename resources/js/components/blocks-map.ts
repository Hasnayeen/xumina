import SideBar from "./block/sidebar";
import TopBar from "./block/topbar";
import Breadcrumb from "./block/breadcrumb";
import PageHeader from "./block/page-header";
import Content from "./block/content";
import Container from "./block/container";

type BlockList =
  | 'Container'
  | 'SideBar'
  | 'TopBar'
  | 'Breadcrumb'
  | 'PageHeader'
  | 'Content'

export interface Block {
  id: string;
  type: BlockList
  data: {
    embeddedView?: (Block)
    items?: Array<(Block)>
    [key: string]: unknown
  }
}

export const Blocks = {
  Container,
  SideBar,
  TopBar,
  Breadcrumb,
  PageHeader,
  Content,
}
