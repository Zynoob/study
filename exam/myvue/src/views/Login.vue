<template>
  <div class="Login">
    <h1>Sigin in to System</h1>
    <div class="container">
      <form>
        <p>
          用户名：
          <span id="name_alert"></span>
        </p>
        <Input v-model="name" placeholder="请输入用户名..." clearable large @on-blur="inputBlur('name')">
          <Icon type="ios-contact" slot="prefix"/>
        </Input>
        <p>密码：</p>
        <Input v-model="password" type="password" placeholder="请输入密码..." clearable large/>
        <span id="login_error_alert" style="color:red"></span>
        <Button type="success" long @click="login(name,password,identity)">Sign in</Button>
        <RadioGroup v-model="identity">
          <Radio label="admin">管理员</Radio>
          <Radio label="teacher">教师</Radio>
          <Radio label="student">学生</Radio>
        </RadioGroup>
      </form>
      <div class="foot">
        <p>
          First visit ?
          <routerLink to="/register">Create an account.</routerLink>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      name: "",
      password: "",
      identity: "student"
    };
  },
  methods: {
    login(name, password, identity) {
      let name_alert = document.querySelector("#name_alert");
      let login_error_alert = document.querySelector("#login_error_alert");
      let verify = () => {
        if (!/^[a-zA-Z][a-zA-Z0-9_]{4,15}$/.test(name)) {
          name_alert.textContent = "用户名不合法";
          return false;
        }
        return true;
      };
      if (!verify()) {
        return;
      }
      this.$mypost("/api/login.php", {
        name,
        password,
        identity
      }).then(result => {
        // console.log(result);
        if (result.data.status == 1) {
          let page = result.data.page;
          sessionStorage.setItem("isLogin", "true");
          sessionStorage.setItem("user_name", name);
          switch (page) {
            case "student":
              this.$router.push("/student");
              break;
            case "teacher":
              this.$router.push("/teacher");
              break;
            case "admin":
              this.$router.push("/admin");
              break;
          }
        } else {
          login_error_alert.textContent = "用户名或者密码错误！";
        }
      });
    },
    inputBlur(name = "") {
      let name_alert = document.querySelector("#name_alert");
      name_alert.textContent = "";
      this[name] = this[name].trim();
    }
  }
};
</script>

<style lang="less" scoped>
.Login {
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

