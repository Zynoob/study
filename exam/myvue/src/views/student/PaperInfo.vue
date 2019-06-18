<template>
  <div class="stu_exam">
    <h1 v-if="currentPage<=(rN)">单选题</h1>
    <h1 v-else-if="currentPage<=(rN+mN)">多选题</h1>
    <h1 v-else>判断题</h1>
    <br>
    <!-- 单选题 -->
    <ul>
      <li v-for="r in rN" :key="r">
        <form>
          <div>
            <p>
              <span style="color:blue;fontSize:10px">(分值: {{radioData[r-1].score}}分)</span>
              <span style="fontSize:16px">( {{ r }} )：</span>
              {{ radioData[r-1].content }}
            </p>
          </div>
          <br>
          <br>
          <div class="answer_radio">
            <RadioGroup type="button" v-model="radioAnswer[r-1]">
              <Radio label="A">
                <span>A:</span>
                {{radioData[r-1].a}}
              </Radio>
              <br>
              <Radio label="B">
                <span>B:</span>
                {{radioData[r-1].b}}
              </Radio>
              <br>
              <Radio label="C">
                <span>C:</span>
                {{radioData[r-1].c}}
              </Radio>
              <br>
              <Radio label="D">
                <span>D:</span>
                {{radioData[r-1].d}}
              </Radio>
            </RadioGroup>
          </div>
        </form>
      </li>
    </ul>
    <!-- 多选题 -->
    <ul>
      <li v-for="m in mN" :key="m">
        <form>
          <div>
            <p>
              <span style="color:blue;fontSize:10px">(分值: {{multipleData[m-1].score}}分)</span>
              <span style="fontSize:16px">( {{ m+rN }} )：</span>
              {{ multipleData[m-1].content }}
            </p>
          </div>
          <br>
          <br>
          <div class="answer_mul">
            <CheckboxGroup v-model="multipleAnswer[m-1]" type="button">
              A:
              <Checkbox label="A">{{multipleData[m-1].a}}</Checkbox>
              <br>B:
              <Checkbox label="B">{{multipleData[m-1].b}}</Checkbox>
              <br>C:
              <Checkbox label="C">{{multipleData[m-1].c}}</Checkbox>
              <br>D:
              <Checkbox label="D">{{multipleData[m-1].d}}</Checkbox>
            </CheckboxGroup>
          </div>
        </form>
      </li>
    </ul>
    <!-- 判断题 -->
    <ul>
      <li v-for="j in jN" :key="j">
        <form>
          <div>
            <p>
              <span style="color:blue;fontSize:10px">(分值: {{judgeData[j-1].score}}分)</span>
              <span style="fontSize:16px">( {{ j+rN+mN }} )：</span>
              {{ judgeData[j-1].content }}
            </p>
          </div>
          <br>
          <br>
          <div>
            <RadioGroup type="button" v-model="judgeAnswer[j-1]">
              <Radio label="t" style="marginRight:20px">
                <span>TRUE</span>
              </Radio>
              <Radio label="f">
                <span>FALSE</span>
              </Radio>
            </RadioGroup>
          </div>
        </form>
      </li>
    </ul>
    <div class="upload">
      <ButtonGroup>
        <Button type="primary" @click="submit()" style="marginRight:25px">
          <Icon type="md-create"/>提交
        </Button>
      </ButtonGroup>
    </div>
    <div class="footPage">
      <Page
        id="pageId"
        :total="sum"
        show-elevator
        :current="currentPage"
        :page-size="1"
        :show-total="true"
        @on-change="changePage"
      />
      <div class="turn">
        <Button type="primary" size="small" @click="turnToPage">跳转</Button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "stu_exam",
  data() {
    return {
      currentPage: 1, //当前页
      rN: 0, //单选题数目
      mN: 0, //多选题数目
      jN: 0, //判断题数目
      sum: 0, //题目总数
      paperId: 0,
      radioData: [],
      radioAnswer: [],
      multipleData: [],
      multipleAnswer: [],
      judgeData: [],
      judgeAnswer: []
    };
  },
  created() {
    let id = this.$route.query.id;
    let paper_data = JSON.parse(sessionStorage.getItem("data"));
    if (paper_data != null) {
      // console.log(paper_data);
      let data = paper_data;
      this.DataInit(data);
    } else {
      this.$mypost("/api/stu/generate_paper.php", {
        id
      })
        .then(rep => {
          console.log(rep);
          if (rep.data.status == 0) {
            this.$Message.error("查询出现错误");
            setTimeout(() => {
              this.$router.go(-1);
            }, 1000);
            return;
          }
          let data = rep.data;
          this.DataInit(data);
          sessionStorage.setItem("data", JSON.stringify(rep.data));
        })
        .catch(err => {
          console.log(err);
        });
    }
  },
  methods: {
    //数据初始化绑定
    DataInit(data) {
      this.paperId = data["paper-id"];
      this.rN = data.radio.length;
      this.mN = data.multiple.length;
      this.jN = data.judge.length;
      this.sum = data.radio.length + data.multiple.length + data.judge.length;
      let arr = [];
      this.radioData = data.radio;
      this.multipleData = data.multiple;
      this.judgeData = data.judge;
      let radio_answer = JSON.parse(sessionStorage.getItem("radioAnswer"));
      let multiple_answer = JSON.parse(
        sessionStorage.getItem("multipleAnswer")
      );
      let judge_answer = JSON.parse(sessionStorage.getItem("judgeAnswer"));
      let currentPage = JSON.parse(sessionStorage.getItem("currentPage"));
      if (currentPage != null) {
        this.currentPage = currentPage;
      }
      if (radio_answer != null) {
        this.radioAnswer = radio_answer;
      } else {
        for (let i = 0; i < this.rN; i++) {
          arr.push("");
        }
        this.radioAnswer = arr;
      }
      if (multiple_answer != null) {
        this.multipleAnswer = multiple_answer;
      } else {
        arr = [];
        for (let i = 0; i < this.mN; i++) {
          arr.push([]);
        }
        this.multipleAnswer = arr;
      }
      if (judge_answer != null) {
        this.judgeAnswer = judge_answer;
      } else {
        arr = [];
        for (let i = 0; i < this.jN; i++) {
          arr.push("");
        }
        this.judgeAnswer = arr;
      }
    },
    changePage(newpage) {
      this.currentPage = newpage;
      this.sava();
      let allform = document.getElementsByTagName("form");
      let upload = document.querySelector(".upload");
      let len = allform.length;
      for (let i = 0; i < len; i++) {
        allform[i].classList.add("hidden");
      }
      upload.classList.add("hidden");
      allform[this.currentPage - 1].classList.remove("hidden");
      if (this.currentPage == this.sum) {
        upload.classList.remove("hidden");
      }
      sessionStorage.setItem("currentPage", this.currentPage);
    },
    //跳转按钮
    turnToPage() {
      var thisPage = document.getElementById("pageId");
      var elevatorDiv = thisPage.getElementsByClassName(
        "ivu-newpage-options-elevator"
      );
      var pageInput = elevatorDiv[0].getElementsByTagName("input")[0].value;
      // console.log(pageInput);
      if (!/\d+/.test(pageInput)) {
        return;
      }
      if (pageInput == this.currentPage) {
        return;
      }
      if (pageInput == 0) {
        this.changePage(1);
        pageInput = "1";
        return;
      }
      if (pageInput > this.sum) {
        this.changePage(this.sum);
        pageInput = this.sum;
        return;
      }
      this.changePage(Number(pageInput));
      return;
    },
    verity() {
      let arr = [];
      for (let index = 0; index < this.multipleAnswer.length; index++) {
        arr[index] = this.multipleAnswer[index].join("");
      }
      if (
        this.radioAnswer.some((val, index) => {
          if (val == 0) {
            this.changePage(index + 1);
            this.$Message.warning("请完成第" + (index + 1) + "题");
            return true;
          }
        })
      ) {
        return false;
      }
      if (
        this.judgeAnswer.some((val, index) => {
          if (val == 0) {
            this.changePage(this.rN + this.mN + index + 1);
            this.$Message.warning(
              "请完成第" + (this.rN + this.mN + index + 1) + "题"
            );
            return true;
          }
        })
      ) {
        return false;
      }
      if (
        arr.some((val, index) => {
          if (val == 0) {
            this.changePage(index + 1 + this.rN);
            this.$Message.warning("请完成第" + (index + 1 + this.rN) + "题");
            return true;
          }
        })
      ) {
        return false;
      }
      return true;
    },
    submit() {
      if (!this.verity()) {
        return false;
      }
      let obj = this.submitData();
      
      this.$mypost("/api/stu/judge_answer.php", {
        answer: obj
      })
        .then(result => {
          // console.log(result);
          if (result.data.status == 1) {
            this.$Message.info("提交试卷成功，<br> 1S后跳转到主页。");
            setTimeout(() => {
              this.$router.push("/student");
            }, 1000);
          } else {
            this.$Message.error("提交试卷失败，<br> 1S后跳转到主页。");
            setTimeout(() => {
              this.$router.push("/student");
            }, 1000);
          }
        })
        .catch(err => {
          console.log(err);
        });
    },
    //刷新保留数据
    sava() {
      sessionStorage.setItem("radioAnswer", JSON.stringify(this.radioAnswer));
      sessionStorage.setItem(
        "multipleAnswer",
        JSON.stringify(this.multipleAnswer)
      );
      sessionStorage.setItem("judgeAnswer", JSON.stringify(this.judgeAnswer));
    },
    submitData() {
      let obj = {
        "paper-id": this.paperId,
        radio: [],
        multiple: [],
        judge: []
      };
      for (let index = 0; index < this.rN; index++) {
        let answer = this.radioAnswer[index];
        let id1 = this.radioData[index]["id"];
        obj.radio.push({ id: id1, answer: answer });
      }
      for (let index = 0; index < this.mN; index++) {
        let answer = this.multipleAnswer[index].join("");
        let id2 = this.multipleData[index]["id"];
        obj.multiple.push({ id: id2, answer: answer });
      }
      for (let index = 0; index < this.jN; index++) {
        let answer = this.judgeAnswer[index];
        let id3 = this.judgeData[index]["id"];
        obj.judge.push({ id: id3, answer: answer });
      }
      // console.log(obj);
      return obj;
    }
  },
  mounted() {
    let paper_data = JSON.parse(sessionStorage.getItem("data"));
    if (paper_data != null) {
      this.changePage(this.currentPage);
      return;
    }
    let t = setInterval(() => {
      if (this.sum != 0) {
        this.changePage(this.currentPage);
        clearInterval(t);
      }
    });
  },
  beforeRouteLeave(to, from, next) {
    let isLogin = sessionStorage.getItem("isLogin");
    let user_name = sessionStorage.getItem("user_name");
    sessionStorage.clear();
    sessionStorage.setItem("isLogin", isLogin);
    sessionStorage.setItem("user_name", user_name);
    next();
  }
};
</script>

<style lang="less" scoped>
.stu_exam {
  height: 500px;
  position: relative;

  /deep/ .ivu-radio-wrapper {
    font-size: 14px;
    margin: 10px 0 10px 0;
  }

  /deep/ .ivu-checkbox-group {
    // display: inline-block;

    /deep/ .ivu-checkbox-wrapper {
      font-size: 14px;
      margin: 10px 0 10px 0;
    }
  }

  .footPage {
    width: 50%;
    position: absolute;
    bottom: -6%;
    margin-left: 25%;
    margin-right: 25%;
    padding-left: 10%;

    /deep/ .ivu-page {
      float: left;
    }

    .turn {
      float: left;
      margin: 4px 0 0 15px;
    }
  }

  .cell {
    box-sizing: border-box;
    width: 40%;
    display: inline-block;
    margin: 10px;
  }

  .upload {
    position: absolute;
    bottom: 6px;
    left: 0;
    right: 0;
  }

  .answer_radio {
    text-align: left;
    margin: 10px 0 10px 20px;
  }

  .answer_mul {
    margin: 10px 0 10px 20px;
    text-align: left;
  }
}
.hidden {
  display: none;
}
</style>
