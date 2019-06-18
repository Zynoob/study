import Vue from 'vue'
import {
    Input,
    Button,
    ButtonGroup,
    Icon,
    Layout,
    Header,
    Content,
    Footer,
    Sider,
    Submenu,
    Menu,
    MenuItem,
    RadioGroup,
    Radio,
    CheckboxGroup,
    Checkbox,
    Page,
    Form,
    FormItem,
    Tabs,
    TabPane,
    Table,
    Message,
    Modal,
    Row,
    Col,
    Select,
    Option
} from 'iview'

Vue.component('Input', Input)
Vue.component('Button', Button)
Vue.component('ButtonGroup', ButtonGroup)
Vue.component('Icon', Icon)
Vue.component('Layout', Layout)
Vue.component('Header', Header)
Vue.component('Content', Content)
Vue.component('RadioGroup', RadioGroup)
Vue.component('Radio', Radio)
Vue.component('CheckboxGroup', CheckboxGroup)
Vue.component('Checkbox', Checkbox)
Vue.component('Footer', Footer)
Vue.component('Sider', Sider)
Vue.component('Submenu', Submenu)
Vue.component('Menu', Menu)
Vue.component('MenuItem', MenuItem)
Vue.component('Page', Page)
Vue.component('Form', Form)
Vue.component('FormItem', FormItem)
Vue.component('Tabs', Tabs)
Vue.component('TabPane', TabPane)
Vue.component('Table', Table)
Vue.component('Row', Row)
Vue.component('Col', Col)
Vue.component('Select', Select)
Vue.component('Option', Option)

Vue.prototype.$Message = Message;
Vue.prototype.$Modal = Modal;
Vue.prototype.$Message.config({
    top: 50,
    duration: 3
});

import 'iview/dist/styles/iview.css'