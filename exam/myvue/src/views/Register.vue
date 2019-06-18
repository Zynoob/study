<template>
  <div class="register">
    <h1>User registration</h1>
    <div class="container">
      <form>
        <p>
          用户名：
          <span id="name_alert"></span>
        </p>
        <Input v-model="name" placeholder="请输入用户名..." clearable large @on-blur="verify(name,0)">
          <Icon type="ios-contact" slot="prefix"/>
        </Input>
        <p>
          密码：
          <span id="password_alert" style="fontSize: 10px;"></span>
        </p>
        <Input
          v-model="password"
          type="password"
          placeholder="请输入密码..."
          clearable
          large
          @on-blur="verify(password,1)"
        />
        <p>确认密码：</p>
        <Input v-model="password_again" type="password" placeholder="请再次输入密码..." clearable large/>
        <Button type="success" long @click="register()">Sign up</Button>
      </form>
      <div class="foot">
        <p>
          Completion of registration ?
          <routerLink to="/login">Login</routerLink>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Register",
  data() {
    return {
      name: "",
      password: "",
      password_again: ""
    };
  },
  methods: {
    verify(content, index = 0) {
      let name_alert = document.querySelector("#name_alert");
      let password_alert = document.querySelector("#password_alert");
      if (content == 0) {
        if (index == 0) {
          name_alert.textContent = "";
        } else {
          password_alert.textContent = "";
        }
        return false;
      }
      if (!/^[a-zA-Z][a-zA-Z0-9_]{4,15}$/.test(content) && index == 0) {
        name_alert.textContent = "用户名字母开头，5-16字节";
        return false;
      } else {
        name_alert.textContent = "";
      }
      if (!/^\w{6,17}$/.test(content) && index == 1) {
        password_alert.textContent =
          "大小写字母、数字与下划线组成，且长度为6~18位";
        return false;
      } else {
        password_alert.textContent = "";
      }
      return true;
    },
    register() {
      if (!this.verify()) {
        return;
      }
      if (this.password != this.password_again) {
        this.$Message.error("俩次密码不相等");
        return;
      }
      this.$mypost("/api/register.php", {
        name: this.name,
        password: this.password
      })
        .then(result => {
          if (result.data.status == 1) {
            this.$Message.success("注册成功<br>1秒后跳转到登录页！");
            setTimeout(() => {
              this.$router.push("/login");
            }, 1500);
          } else {
            this.$Message.error(result.msg);
          }
          // console.log(result);
        })
        .catch(err => {
          console.log(err);
        });
    }
  }
};
</script>

<style lang="less" scoped>
.register {
  position: relative;
  overflow: hidden;
  height: 100vh;
  background-color: #f9f9f9;
  color: #24292e;
  font-size: 14px;
  line-height: 1.5;

  h1 {
    position: absolute;
    top: 100px;
    left: 50%;
    font-size: 24px;
    font-weight: 300;
    letter-spacing: -0.5px;
    text-align: center;
    transform: translate(-50%, 0);
  }
}
.container {
  margin: 27vh auto 0;
  width: 340px;
  height: 30%;
  background: rgba(255, 255, 255);
  border-radius: 5px;
  border-top: 1px solid #d8dee2;
  padding: 20px;

  p {
    text-align: left;
    margin: 0 0 5px;
    font-weight: 600;

    span {
      float: right;
      color: red;
      font-size: 14px;
      font-weight: 300;
    }
  }

  /deep/ .ivu-input {
    margin: 0 0 7px;
    background-color: #e8f0fe;
    font-size: 16px;
  }

  /deep/ .ivu-btn {
    margin: 3px 0 7px;
    font-size: 14px;
  }

  /deep/ .ivu-radio-group {
    margin-bottom: 5px;

    .ivu-radio-wrapper {
      margin-right: 14px;
    }
  }
  .foot {
    height: 50px;
    margin-top: 40px;
    border: 1px solid #d8dee2;
    border-radius: 5px;
    padding: 15px 20px;
    p {
      text-align: center;
    }
  }
}
</style>

