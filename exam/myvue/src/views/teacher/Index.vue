<template>
  <div class="layout">
    <p class="logo">
      欢迎，
      <span class="name">{{ user_name }}</span>
    </p>
    <Layout>
      <Header>
        <Menu mode="horizontal" theme="dark" active-name="1">
          <MenuItem name="1" @click.native="login_out()">
            <Icon type="ios-power-outline"/>注销
          </MenuItem>
          <MenuItem name="2" to="/teacher/personinfo">
            <Icon type="ios-contact"/>个人中心
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
                    <Icon type="ios-keypad"></Icon>创建
                  </template>
                  <MenuItem name="1-1" to="/teacher/buildpaper">创建试卷</MenuItem>
                  <MenuItem name="1-2" to="/teacher/single">创建试题</MenuItem>
                </Submenu>
                <Submenu name="2">
                  <template slot="title">
                    <Icon custom="iconfont icon-chaxun"/>查询
                  </template>
                  <MenuItem name="2-1" to="/teacher/search">查询学生试卷成绩</MenuItem>
                  <MenuItem name="2-2" to="/teacher/mypaper">我的试卷</MenuItem>
                </Submenu>
              </Menu>
            </Sider>
            <Content :style="{padding: '24px', minHeight: '280px', background: '#fff'}">
              <div v-if="$route.name == 'teacher'">这是教师页面</div>
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
  name: "teacher",
  data() {
    return {
      user_name: ""
    };
  },
  created() {
    this.user_name = sessionStorage.getItem("user_name");
  },
  methods: {
    login_out() {
      let onOk = () => {
        this.$mypost("/api/login_out.php")
          .then(data => {
            if (data.status == 1) {
              this.$router.push("/login");
            }
          })
          .catch(err => {
            console.log(err);
          });
      };
      this.$Modal.confirm({
        title: "退出登录！",
        content: "是否退出登录？",
        okText: "退出",
        cancelText: "取消",
        onOk: onOk
      });
      // console.log(1);
    }
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
    font-size: 14px;
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
/deep/.ivu-menu-dark {
  background: transparent;
}
/deep/ .ivu-layout-sider-children {
  height: calc(100vh - 166px);

  /deep/ .ivu-menu-vertical.ivu-menu-light {
    &::after {
      height: calc(100vh - 180px);
    }
  }
}

/deep/ .ivu-menu-horizontal .ivu-menu-item {
  float: right;
}
/deep/ .ivu-menu-horizontal .ivu-menu-submenu {
  float: right;
}
</style>
