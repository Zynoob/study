<template>
  <div class="layout">
    <p class="logo">
      欢迎，
      <span class="name">{{user_name }}</span>
    </p>
    <Layout>
      <Header>
        <Menu mode="horizontal" theme="dark" active-name="1">
          <MenuItem name="1" @click.native="$router.go(-1)">
            <Icon type="ios-return-left"/>返回
          </MenuItem>
          <MenuItem name="2" to="/teacher">
            <Icon type="ios-return-left"/>返回首页
          </MenuItem>
        </Menu>
      </Header>
      <Layout :style="{padding: '0 50px'}">
        <Content
          :style="{padding: '24px 0', margin:'20px 0 0',height:'calc(100vh - 142px)', background: '#fff'}"
        >
          <Layout>
            <Sider hide-trigger :style="{background: '#fff'}">
              <Menu theme="light" width="auto">
                <Submenu name="1">
                  <template slot="title">
                    <Icon type="ios-keypad"></Icon>个人信息
                  </template>
                  <MenuItem name="1-1" to="/teacher/personinfo/baseinfo">基本信息</MenuItem>
                  <MenuItem name="1-2" to="/teacher/personinfo/modifypwd">修改密码</MenuItem>
                </Submenu>
              </Menu>
            </Sider>
            <Content :style="{padding: '24px', minHeight: '280px', background: '#fff'}">
              <div v-if="$route.name == 'teacher_personinfo'">这是个人信息页面</div>
              <keep-alive>
                <router-view></router-view>
              </keep-alive>
            </Content>
          </Layout>
        </Content>
      </Layout>
      <Footer class="layout-footer-center">2019 &copy; =.=</Footer>
    </Layout>
  </div>
</template>

<script>
export default {
  name: "teaPersonInfo",
  data() {
    return {
      user_name: ""
    };
  },
  created() {
    this.user_name = sessionStorage.getItem("user_name");
  }
};
</script>

<style lang="less" scoped>
.logo {
  height: 64px;
  line-height: 64px;
  margin-left: 20px;
  float: left;
  position: absolute;
  color: white;
  font-size: 10px;

  .name {
    color: rgb(4, 243, 132);
  }
}
.layout {
  height: 100vh;
  border: 1px solid #d7dde4;
  background: #f5f7f9;
  position: relative;
  border-radius: 4px;
  overflow: hidden;

  .layout-footer-center {
    text-align: center;
  }
}

/deep/ .ivu-layout-sider-children {
  height: calc(100vh - 166px);

  /deep/ .ivu-menu-vertical.ivu-menu-light {
    &::after {
      height: calc(100vh - 180px);
    }
  }
}
/deep/.ivu-menu-dark {
  background: transparent;
}

/deep/ .ivu-menu-horizontal .ivu-menu-item {
  float: right;
}
/deep/ .ivu-menu-horizontal .ivu-menu-submenu {
  float: right;
}
</style>
