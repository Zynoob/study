<template>
  <div class="teacher_base_info">
    <form>
      <span>用户名</span>
      ：{{name}}
      <br>
      <br>
      <div v-show="disabled">
        <br>
        <p class="cell">
          姓名：
          <span v-if="truename==0||truename==null">无</span>
          <span v-else>{{ truename }}</span>
        </p>
        <br>
        <p class="cell">
          邮箱：
          <span v-if="email==0||email==null">无</span>
          <span v-else>{{ email }}</span>
        </p>
        <br>
        <p class="cell">
          地址：
          <span v-if="address==0||address==null">无</span>
          <span v-else>{{ address }}</span>
        </p>
        <br>
        <p class="cell">
          手机号：
          <span v-if="phone==0||phone==null">无</span>
          <span v-else>{{ phone }}</span>
        </p>
      </div>
      <div v-show="!disabled">
        <br>姓名：
        <Input v-model="truename" :style="style[0]" @on-blur="truename=truename.trim()"/>
        <br>邮箱：
        <Input v-model="email" :style="style[0]" @on-blur="email=email.trim()"/>
        <br>地址：
        <Input v-model="address" :style="style[0]" @on-blur="address=address.trim()"/>
        <br>手机号：
        <Input v-model="phone" :style="style[0]" @on-blur="phone=phone.trim()"/>
      </div>
      <br>
      <br>
      <ButtonGroup>
        <Button type="primary" @click="edit()" style="marginRight:25px" :disabled="btnStatus">
          <Icon type="md-create"/>编辑
        </Button>
        <Button type="primary" @click="save()" :disabled="!btnStatus">
          <Icon type="md-checkmark-circle"/>保存
        </Button>
      </ButtonGroup>
    </form>
  </div>
</template>

<script>
export default {
  name: "teacher_base_info",
  data() {
    return {
      name: "",
      subjectName: "",
      truename: "",
      email: "",
      address: "",
      phone: "",
      disabled: true,
      btnStatus: false,
      style: [
        {
          width: "200px",
          margin: "5px auto"
        }
      ],
      temp: {}
    };
  },
  methods: {
    edit() {
      this.disabled = false;
      this.btnStatus = !this.btnStatus;
      this.temp = {
        truename: this.truename,
        email: this.email,
        address: this.address,
        phone: this.phone
      };
    },
    verify() {
      if (
        !/^[\u4E00-\u9FA5A-Za-z]+$/.test(this.truename) &&
        this.truename != 0 &&
        this.truename != null
      ) {
        this.$Message.warning("姓名只能为中文与英文字符组成！");
        return false;
      }
      if (
        !/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(this.email) &&
        this.email != 0 &&
        this.email != null
      ) {
        this.$Message.warning("邮箱格式错误！");
        return false;
      }
      if (
        !/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/.test(
          this.phone
        ) &&
        this.phone != 0 &&
        this.phone != null
      ) {
        this.$Message.warning("手机号格式错误！");
        return false;
      }
      return true;
    },
    async save() {
      if (!this.verify()) {
        return;
      }
      let obj = {
        truename: this.truename,
        email: this.email,
        address: this.address,
        phone: this.phone
      };
      let oldVal = Object.values(this.temp);
      let newVal = Object.values(obj);
      if (oldVal.toString() == newVal.toString()) {
        this.btnStatus = !this.btnStatus;
        this.disabled = true;
        return;
      }
      let data = await this.$mypost("/api/stu/set_person_info.php", {
        info: obj
      });
      if (data.data.status == 0) {
        this.$Message.error(data.msg);
      } else {
        this.$Message.success("基本信息修改成功");
      }
      // console.log(data);

      this.disabled = true;
      this.btnStatus = !this.btnStatus;
      this.initData();
    },
    async initData() {
      try {
        let res = await this.$mypost("/api/stu/get_person_info.php");
        // console.log(res);
        this.name = res.data.name;
        this.subjectName = res.data.subjectName;
        this.truename = res.data.truename;
        this.email = res.data.email;
        this.address = res.data.address;
        this.phone = res.data.phone;
      } catch (error) {
        console.log(error);
      }
    }
  },
  created() {
    this.initData();
  }
};
</script>

<style lang="less">
.teacher_base_info {
  width: 100%;
  height: 100%;

  .cell {
    width: 200px;
    height: 32px;
    line-height: 32px;
    margin: 0 auto;
    text-align: left;
  }
}
</style>
