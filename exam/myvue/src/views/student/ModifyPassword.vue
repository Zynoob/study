<template>
  <div class="tea_modify_pwd">
    <br>旧密码：
    <Input
      v-model="oldPwd"
      type="password"
      :disabled="disabled"
      :style="style[0]"
      @on-blur="blur_verify(0)"
    />
    <br>新密码：
    <Input
      v-model="newPwd"
      type="password"
      :disabled="disabled"
      :style="style[0]"
      @on-blur="blur_verify(1)"
    />
    <br>再次输入：
    <Input
      v-model="newPwd_again"
      type="password"
      :disabled="disabled"
      :style="style[0]"
      @on-blur="blur_verify(2)"
    />
    <br>
    <br>
    <ButtonGroup>
      <Button type="primary" @click="edit()" style="marginRight:25px">
        <Icon type="md-create"/>
        {{edit_textcontent}}
      </Button>
      <Button type="primary" @click="modify()" style="marginRight:25px" :disabled="!btnStatus">
        <Icon type="md-create"/>修改密码
      </Button>
    </ButtonGroup>
  </div>
</template>

<script>
export default {
  name: "tea_modify_pwd",
  data() {
    return {
      oldPwd: "",
      newPwd: "",
      newPwd_again: "",
      edit_textcontent: "编辑",
      disabled: true,
      btnStatus: false,
      style: [
        {
          width: "200px",
          margin: "5px auto"
        }
      ]
    };
  },
  methods: {
    edit() {
      this.disabled = !this.disabled;
      this.btnStatus = !this.btnStatus;
      if (this.edit_textcontent == "放弃编辑") {
        this.oldPwd = "";
        this.newPwd = "";
        this.newPwd_again = "";
      }
      this.edit_textcontent =
        this.edit_textcontent == "编辑" ? "放弃编辑" : "编辑";
    },
    blur_verify(num) {
      let arr = [this.oldPwd, this.newPwd, this.newPwd_again];
      let value = arr[num];
      if (value == 0) {
        return false;
      }
      if (!/^\w{6,17}$/.test(value)) {
        this.$Message.warning(
          "密码只能用大小写字母、数字与下划线组成，且长度为6~18位"
        );
        return false;
      }
      return true;
    },
    verify() {
      let arr = [this.oldPwd, this.newPwd, this.newPwd_again];
      if (arr.some(val => val == 0)) {
        this.$Message.warning("请填写完整");
        return;
      }
      if (
        !this.blur_verify(0) ||
        !this.blur_verify(1) ||
        !this.blur_verify(2)
      ) {
        this.$Message.error(
          "密码只能用大小写字母、数字与下划线组成，且长度为6~18位"
        );
        return false;
      }
      if (this.newPwd != this.newPwd_again) {
        this.$Message.error("俩次密码不相等");
        return false;
      }
      if (this.newPwd == this.oldPwd) {
        this.$Message.error("新旧密码不能相同");
        return false;
      }
      return true;
    },
    async modify() {
      if (!this.verify()) {
        return;
      }
      let data = await this.$mypost("/api/stu/modify_password.php", {
        oldPassword: this.oldPwd,
        password: this.newPwd
      });
      // console.log(data);
      if (data.data.status == 0) {
        this.$Message.error(data.msg);
      } else {
        this.$Message.success("密码修改成功");
      }
      this.edit();
    }
  }
};
</script>

<style lang="less">
.tea_modify_pwd {
  height: 100%;
  width: 100%;
}
</style>
