<template>
  <div class="paper">
    <form>
      试卷标题
      <span style="color:red">*</span>：
      <Input
        v-model="title"
        placeholder="请输入标题"
        clearable
        style="width: 200px"
        @on-blur="title = title.trim()"
      />
      <br>单选题数量：
      <Input v-model="radioNum" type="number" :style="style[0]"/>
      <br>单选题分数：
      <Input v-model="radioScore" type="number" :style="style[0]"/>
      <br>多选题数量：
      <Input v-model="multipleNum" type="number" :style="style[0]"/>
      <br>多选题分数：
      <Input v-model="mulScore" type="number" :style="style[0]"/>
      <br>判断题数量：
      <Input v-model="judgeNum" type="number" :style="style[0]"/>
      <br>判断题分数：
      <Input v-model="judgeScore" type="number" :style="style[0]"/>
      <br>考试时长
      <span style="color:red">*</span>：
      <Input v-model="duration" type="number" placeholder="格式为：1~180(分钟)" :style="style[0]"/>
      <br>
      <Input
        v-model="desc"
        type="textarea"
        placeholder="试卷描述 *"
        clearable
        :autosize="{ minRows: 2, maxRows: 6 }"
        style="width: 400px"
        @on-blur="desc = desc.trim()"
      />
      <br>
      <Button type="success" icon="md-checkmark" @click="buildpaper()">确认</Button>
    </form>
  </div>
</template>

<script>
export default {
  name: "paper",
  data() {
    return {
      title: "",
      desc: "",
      radioNum: 0,
      multipleNum: 0,
      judgeNum: 0,
      radioScore: 0,
      mulScore: 0,
      judgeScore: 0,
      duration: 0,
      style: [
        {
          width: "200px",
          margin: "5px auto"
        }
      ]
    };
  },
  methods: {
    buildpaper() {
      //验证表单内容
      if (!this.formManage()) {
        return false;
      }
      sessionStorage.setItem("title", this.title);
      sessionStorage.setItem("desc", this.desc);
      sessionStorage.setItem("duration", this.duration);
      sessionStorage.setItem("radioNum", this.radioNum);
      sessionStorage.setItem("multipleNum", this.multipleNum);
      sessionStorage.setItem("judgeNum", this.judgeNum);
      sessionStorage.setItem("radioScore", this.radioScore);
      sessionStorage.setItem("mulScore", this.mulScore);
      sessionStorage.setItem("judgeScore", this.judgeScore);
      this.$router.push("/teacher/paperinfo");
    },
    formManage() {
      this.radioNum = Math.round(this.radioNum);
      this.multipleNum = Math.round(this.multipleNum);
      this.judgeNum = Math.round(this.judgeNum);
      this.radioScore = Math.round(this.radioScore);
      this.mulScore = Math.round(this.mulScore);
      this.judgeScore = Math.round(this.judgeScore);
      this.duration = Math.round(this.duration);
      let arr = [
        this.radioNum,
        this.multipleNum,
        this.judgeNum,
        this.radioScore,
        this.mulScore,
        this.judgeScore
      ];
      if (this.title == "" || this.desc == "") {
        this.$Message.warning("标题/描述不能为空");
        return false;
      }
      if (this.duration > 180 || this.duration < 1) {
        this.$Message.warning("时间设置错误");
        return false;
      }
      if (arr.some(val => val < 0)) {
        this.$Message.warning("试题与分数不能为负数");
        return false;
      }
      if (arr[0] + arr[1] + arr[2] == 0) {
        this.$Message.warning("试题总数不能为0");
        return false;
      }
      if (arr[0] > 0) {
        if (arr[3] <= 0) {
          this.$Message.warning("单选题分数不能为0");
          return false;
        }
      } else {
        this.radioScore = 0;
      }
      if (arr[1] > 0) {
        if (arr[4] <= 0) {
          this.$Message.warning("多选题分数不能为0");
          return false;
        }
      } else {
        this.mulScore = 0;
      }
      if (arr[2] > 0) {
        if (arr[5] <= 0) {
          this.$Message.warning("判断题分数不能为0");
          return false;
        }
      } else {
        this.judgeScore = 0;
      }
      return true;
    }
  }
};
</script>

<style lang="less" scope>
.paper {
  position: relative;
  height: 100%;

  /deep/ .ivu-btn-success {
    font-size: 14px;
    width: 100px;
    position: absolute;
    bottom: 0;
    left: 45%;
  }
}
</style>
