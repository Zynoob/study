<template>
  <div class="creat-teacher">
    <form class="creat">
      <p class="pre_input_text">用户名：</p>
      <Input
        v-model="name"
        placeholder="请输入用户名..."
        clearable
        large
        @on-blur="name=name.trim()"
        :style="input_style"
      >
        <Icon type="ios-contact" slot="prefix"/>
      </Input>&nbsp;科目：
      <Select v-model="subject_id" style="width:100px">
        <Option v-for="item in subjectList" :value="item.id" :key="item.id">{{ item.name }}</Option>
      </Select>
      <br>
      <div class="pre_input_text">密码：</div>
      <Input
        v-model="password"
        type="password"
        placeholder="请输入密码..."
        clearable
        large
        :style="input_style"
      />
      <br>
      <div class="pre_input_text">确认密码：</div>
      <Input
        v-model="password_again"
        type="password"
        placeholder="请再次输入密码..."
        clearable
        large
        :style="input_style"
      />
      <br>
      <div class="pre_input_text">姓名:</div>
      <Input
        v-model="truename"
        placeholder="用户姓名..."
        clearable
        large
        :style="input_style"
        @on-blur="truename=truename.trim()"
      />
      <br>
      <div class="pre_input_text">邮箱:</div>
      <Input
        v-model="email"
        placeholder="用户邮箱..."
        clearable
        large
        :style="input_style"
        @on-blur="email=email.trim()"
      />
      <br>
      <div class="pre_input_text">地址:</div>
      <Input
        v-model="address"
        placeholder="用户地址..."
        clearable
        large
        :style="input_style"
        @on-blur="address=address.trim()"
      />
      <br>
      <div class="pre_input_text">手机号:</div>
      <Input
        v-model="phone"
        placeholder="用户手机号..."
        clearable
        large
        :style="input_style"
        @on-blur="phone=phone.trim()"
      />
      <br>

      <br>
      <br>
      <br>
      <ButtonGroup style="width:200px;margin:0 30%;">
        <Button type="primary" @click="submit()" style="marginRight:25px">
          <Icon type="md-create"/>提交
        </Button>
        <Button type="primary" @click="reset()">
          重置
          <Icon type="ios-undo"/>
        </Button>
      </ButtonGroup>
    </form>
  </div>
</template>

<script>
export default {
  name: "creatTeacher",
  data() {
    return {
      name: "",
      password: "",
      password_again: "",
      email: "",
      address: "",
      phone: "",
      truename: "",
      subjectList: [],
      subject_id: "",
      input_style: {
        width: "500px",
        marginLeft: "10px"
      }
    };
  },
  methods: {
    verify() {
      if (!/^[a-zA-Z][a-zA-Z0-9_]{4,15}$/.test(this.name)) {
        this.$Message.warning(
          "账号不合法,字母开头，允许5-16字节，允许字母数字下划线"
        );
        return false;
      }
      if (
        !/^\w{6,17}$/.test(this.password) ||
        !/^\w{6,17}$/.test(this.password_again)
      ) {
        this.$Message.warning(
          "密码只能用大小写字母、数字与下划线组成，且长度为6~18位"
        );
        return false;
      }
      if (this.password != this.password_again) {
        this.$Message.error("俩次密码不相等");
        return false;
      }
      if (this.subject_id == 0) {
        this.$Message.warning("科目不能为空");
        return false;
      }
      if (
        !/^[\u4E00-\u9FA5A-Za-z]+$/.test(this.truename) &&
        this.truename != 0
      ) {
        this.$Message.warning("姓名只能为中文与英文字符组成！");
        return false;
      }
      if (
        !/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(this.email) &&
        this.email != 0
      ) {
        this.$Message.warning("邮箱格式错误！");
        return false;
      }
      if (
        !/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/.test(
          this.phone
        ) &&
        this.phone != 0
      ) {
        this.$Message.warning("手机号格式错误！");
        return false;
      }
      return true;
    },
    submit() {
      if (!this.verify()) {
        return;
      }
      this.$mypost("/api/admin/register.php", {
        name: this.name,
        password: this.password,
        subject_id: this.subject_id,
        truename: this.truename,
        email: this.email,
        address: this.address,
        phone: this.phone
      })
        .then(result => {
          if (result.data.status == 0) {
            this.$Message.error(result.msg);
          } else {
            this.$Message.success("教师用户注册成功");
          }
          this.reset();
        })
        .catch(err => {
          console.log(err);
        });
    },
    reset() {
      this.name = "";
      this.password = "";
      this.password_again = "";
      this.email = "";
      this.address = "";
      this.phone = "";
      this.truename = "";
      this.subject_id = "";
    },
    initSubjectList() {
      this.$mypost("/api/admin/get_subject.php")
        .then(result => {
          // console.log(result);
          this.subjectList = result.data.subject;
        })
        .catch(err => {
          console.log(err);
        });
    }
  },
  created() {
    this.initSubjectList();
  }
};
</script>

<style lang="less">
.creat-teacher {
  width: 100%;
  height: 100%;

  .creat {
    width: 70%;
    margin: 0 auto;
    text-align: left;
  }

  .pre_input_text {
    width: 100px;
    display: inline-block;
    margin: 20px;
  }
}
</style>
