<template>
  <div class="question">
    <h1 v-if="currentPage<=(rN)">单选题</h1>
    <h1 v-else-if="currentPage<=(rN+mN)">多选题</h1>
    <h1 v-else>判断题</h1>
    <br>
    <!-- 单选题 -->
    <ul>
      <li v-for="r in rN" :key="r">
        <form>
          题干
          <span style="color:red">*</span>：
          <Input
            v-model="radioData[r-1].content"
            type="textarea"
            placeholder="试题内容"
            :autosize="{ minRows: 2, maxRows: 6 }"
            style="width: 400px"
            @on-blur="inputTrim('radioData',r-1,'content')"
          />
          <br>
          <br>
          <div class="cell">
            选项A:
            <Input
              v-model="radioData[r-1].A"
              type="textarea"
              placeholder="这是A"
              :rows="2"
              style="width: 300px"
              @on-blur="inputTrim('radioData',r-1,'A')"
            />
          </div>
          <div class="cell">
            选项B:
            <Input
              v-model="radioData[r-1].B"
              type="textarea"
              placeholder="这是B"
              :rows="2"
              style="width: 300px"
              @on-blur="inputTrim('radioData',r-1,'B')"
            />
          </div>
          <br>
          <div class="cell">
            选项C:
            <Input
              v-model="radioData[r-1].C"
              type="textarea"
              placeholder="这是C"
              :rows="2"
              style="width: 300px"
              @on-blur="inputTrim('radioData',r-1,'C')"
            />
          </div>
          <div class="cell">
            选项D:
            <Input
              v-model="radioData[r-1].D"
              type="textarea"
              placeholder="这是D"
              :rows="2"
              style="width: 300px"
              @on-blur="inputTrim('radioData',r-1,'D')"
            />
          </div>
          <br>
          <br>
          <div style="fontSize:14px">
            正确答案：
            <RadioGroup v-model="radioData[r-1].trueAnswer">
              <Radio label="A"></Radio>
              <Radio label="B"></Radio>
              <Radio label="C"></Radio>
              <Radio label="D"></Radio>
            </RadioGroup>
          </div>
          <br>解析：
          <Input
            v-model="radioData[r-1].analysis"
            type="textarea"
            placeholder="解析*"
            :autosize="{ minRows: 2, maxRows: 6 }"
            style="width: 400px"
            @on-blur="inputTrim('radioData',r-1,'analysis')"
          />
        </form>
      </li>
    </ul>
    <!-- 多选题 -->
    <ul>
      <li v-for="m in mN" :key="m">
        <form>
          题干
          <span style="color:red">*</span>：
          <Input
            v-model="multipleData[m-1].content"
            type="textarea"
            placeholder="试题内容"
            :autosize="{ minRows: 2, maxRows: 6 }"
            style="width: 400px"
            @on-blur="inputTrim('multipleData',m-1,'content')"
          />
          <br>
          <br>
          <div class="cell">
            选项A:
            <Input
              v-model="multipleData[m-1].A"
              type="textarea"
              placeholder="这是A"
              :rows="2"
              style="width: 300px"
              @on-blur="inputTrim('multipleData',m-1,'A')"
            />
          </div>
          <div class="cell">
            选项B:
            <Input
              v-model="multipleData[m-1].B"
              type="textarea"
              placeholder="这是B"
              :rows="2"
              style="width: 300px"
              @on-blur="inputTrim('multipleData',m-1,'B')"
            />
          </div>
          <br>
          <div class="cell">
            选项C:
            <Input
              v-model="multipleData[m-1].C"
              type="textarea"
              placeholder="这是C"
              :rows="2"
              style="width: 300px"
              @on-blur="inputTrim('multipleData',m-1,'C')"
            />
          </div>
          <div class="cell">
            选项D:
            <Input
              v-model="multipleData[m-1].D"
              type="textarea"
              placeholder="这是D"
              :rows="2"
              style="width: 300px"
              @on-blur="inputTrim('multipleData',m-1,'D')"
            />
          </div>
          <br>
          <br>
          <div style="fontSize:14px">
            正确答案：
            <CheckboxGroup v-model="multipleData[m-1].trueAnswer">
              <Checkbox label="A"></Checkbox>
              <Checkbox label="B"></Checkbox>
              <Checkbox label="C"></Checkbox>
              <Checkbox label="D"></Checkbox>
            </CheckboxGroup>
          </div>
          <br>解析：
          <Input
            v-model="multipleData[m-1].analysis"
            type="textarea"
            placeholder="解析*"
            :autosize="{ minRows: 2, maxRows: 6 }"
            style="width: 400px"
            @on-blur="inputTrim('multipleData',m-1,'analysis')"
          />
        </form>
      </li>
    </ul>
    <!-- 判断题 -->
    <ul>
      <li v-for="j in jN" :key="j">
        <form>
          题干
          <span style="color:red">*</span>：
          <Input
            v-model="judgeData[j-1].content"
            type="textarea"
            placeholder="试题内容"
            :rows="4"
            style="width: 400px"
            @on-blur="inputTrim('judgeData',j-1,'content')"
          />
          <br>
          <br>
          <div style="fontSize:14px">
            正确答案：
            <RadioGroup v-model="judgeData[j-1].trueAnswer">
              <Radio label="t">True</Radio>
              <Radio label="f">False</Radio>
            </RadioGroup>
          </div>
          <br>解析：
          <Input
            v-model="judgeData[j-1].analysis"
            type="textarea"
            placeholder="解析*"
            :autosize="{ minRows: 4, maxRows: 6 }"
            style="width: 400px"
            @on-blur="inputTrim('judgeData',j-1,'analysis')"
          />
        </form>
      </li>
    </ul>
    <div class="upload">
      <ButtonGroup>
        <Button type="primary" @click="submit()" style="marginRight:25px">
          <Icon type="md-create"/>提交
        </Button>
        <Button type="primary" @click="toTeacherPage()">
          返回
          <Icon type="ios-undo"/>
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
  name: "questions",
  data() {
    return {
      currentPage: 1, //当前页
      rN: 0, //单选题数目
      mN: 0, //多选题数目
      jN: 0, //判断题数目
      sum: 0, //题目总数
      radioData: [],
      multipleData: [],
      judgeData: []
    };
  },
  beforeRouteEnter(to, from, next) {
    if (from.name == "teacher_buildpaper" || from.name == null) {
      next();
    } else {
      next("/teacher/buildpaper");
    }
  },
  created() {
    this.rN = Number(sessionStorage.getItem("radioNum"));
    this.mN = Number(sessionStorage.getItem("multipleNum"));
    this.jN = Number(sessionStorage.getItem("judgeNum"));
    this.sum = this.rN + this.mN + this.jN;
    let page = JSON.parse(sessionStorage.getItem("currentPage"));
    if (page != null) {
      this.currentPage = page;
    }
    this.DataInit();
    this.loadData();
  },
  mounted() {
    this.changePage(this.currentPage);
  },
  methods: {
    //数据绑定
    DataInit() {
      let radio_obj = {
        content: "",
        A: "",
        B: "",
        C: "",
        D: "",
        trueAnswer: "",
        analysis: ""
      };
      let multip_obj = {
        content: "",
        A: "",
        B: "",
        C: "",
        D: "",
        trueAnswer: [],
        analysis: ""
      };
      let judge_obj = {
        content: "",
        trueAnswer: "",
        analysis: ""
      };
      for (let index = 0; index < this.rN; index++) {
        let newobj = Object.assign({}, radio_obj);
        this.radioData.splice(index, 1, newobj);
      }
      for (let index = 0; index < this.mN; index++) {
        let newobj = Object.assign({}, multip_obj);
        this.multipleData.splice(index, 1, newobj);
      }
      for (let index = 0; index < this.jN; index++) {
        let newobj = Object.assign({}, judge_obj);
        this.judgeData.splice(index, 1, newobj);
      }
    },
    changePage(newpage) {
      //保存数据到SessionStorage
      let oldpage = this.currentPage;
      this.savaData(oldpage);
      // console.log(newpage);
      this.currentPage = newpage;
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
    toTeacherPage() {
      if (confirm("是否放弃当前创建的试卷？")) {
        clearSessionStorage();
        this.$router.replace("/teacher/buildpaper");
      } else {
        return false;
      }
      function clearSessionStorage() {
        sessionStorage.removeItem("title");
        sessionStorage.removeItem("desc");
        sessionStorage.removeItem("duration");
        sessionStorage.removeItem("radioNum");
        sessionStorage.removeItem("radioScore");
        sessionStorage.removeItem("multipleNum");
        sessionStorage.removeItem("mulScore");
        sessionStorage.removeItem("judgeNum");
        sessionStorage.removeItem("judgeScore");
        sessionStorage.removeItem("currentPage");
        for (let i = 1; i <= this.sum; i++) {
          sessionStorage.removeItem("n" + i);
        }
      }
    },
    //去除首尾空格
    inputTrim(obj = "", index = 1, name = "") {
      this[obj][index][name] = this[obj][index][name].trim();
    },
    //
    savaData(oldpage) {
      let getContent = (oldval = 1) => {
        let obj = [];
        if (oldval <= this.rN) {
          let data = this.radioData[oldval - 1];
          obj.push(data.content);
          obj.push(data.A);
          obj.push(data.B);
          obj.push(data.C);
          obj.push(data.D);
          obj.push(data.trueAnswer);
          obj.push(data.analysis);
        } else if (oldval <= this.rN + this.mN) {
          let data = this.multipleData[oldval - this.rN - 1];
          obj.push(data.content);
          obj.push(data.A);
          obj.push(data.B);
          obj.push(data.C);
          obj.push(data.D);
          obj.push(data.trueAnswer.join(""));
          obj.push(data.analysis);
        } else {
          let num = this.rN + this.mN;
          let data = this.judgeData[oldval - num - 1];
          obj.push(data.content);
          obj.push(data.trueAnswer);
          obj.push(data.analysis);
        }
        return obj;
      };
      let arr = getContent(oldpage);
      sessionStorage.setItem("n" + oldpage, JSON.stringify(arr));
    },
    noNullverify() {
      //数组是否存在空字符串
      let existNull = function(arr, len) {
        if (arr.length == len) {
          let index = arr.indexOf("") + 1;
          if (index) {
            return true;
          } else {
            return false;
          }
        } else {
          // console.log("正确答案不能为空！");
          return true;
        }
      };
      //总题数是否满足
      let that = this;
      let judgeQuesNum = function() {
        for (let i = 1; i <= that.sum; i++) {
          let str = JSON.parse(sessionStorage.getItem("n" + i));
          if (str == null) {
            that.currentPage = i;
            that.changePage(i);
            return false;
          }
        }
        return true;
      };
      // 是否存在未完成题目，start开始位置，end结束位置，len输入内容的条目数量
      let judge = function(start, end, len) {
        for (let i = start; i <= end; i++) {
          let str = JSON.parse(sessionStorage.getItem("n" + i));
          if (existNull(str, len)) {
            //存在有选项未输入，跳转到当前页
            that.currentPage = i;
            that.changePage(i);
            return false;
          }
        }
        return true;
      };
      // judge(1,this.rN);//单选题
      // judge(this.rN + 1,this.rN + this.mN);//多选题
      // judge(this.rN + this.mN + 1,this.sum);//判断题
      if (judgeQuesNum()) {
        return judge(1, this.rN, 7) &&
          judge(this.rN + 1, this.rN + this.mN, 7) &&
          judge(this.rN + this.mN + 1, this.sum, 3)
          ? true
          : false;
      } else {
        return false;
      }
    },
    submit() {
      //保存最后一页数据
      this.savaData(this.sum);
      if (!this.noNullverify()) {
        return;
      }
      //数据整合
      let get = data => JSON.parse(sessionStorage.getItem(data));
      let dataCollection = () => {
        let obj = {};
        let title = sessionStorage.getItem("title");
        let desc = sessionStorage.getItem("desc");
        let duration = get("duration");
        let radioNum = get("radioNum");
        let multipleNum = get("multipleNum");
        let judgeNum = get("judgeNum");
        let radioScore = get("radioScore");
        let mulScore = get("mulScore");
        let judgeScore = get("judgeScore");
        obj.title = title;
        obj.duration = duration;
        obj.radioNum = radioNum;
        obj.multipleNum = multipleNum;
        obj.judgeNum = judgeNum;
        obj.desc = desc;
        obj.radioScore = radioScore;
        obj.mulScore = mulScore;
        obj.judgeScore = judgeScore;
        for (let index = 1; index <= this.sum; index++) {
          const arr = get("n" + index);
          obj["n" + index] = arr;
        }
        return obj;
      };
      let obj = dataCollection();
      console.log(obj);
      this.$mypost("/api/tea/buildPaper.php", {
        paper: obj
      })
        .then(data => {
          // console.log(data);
          if (data.data.status == 1) {
            this.$Message.success("创建成功");
          } else {
            this.$Message.error("创建失败");
          }
          setTimeout(() => this.$router.push("/teacher"), 1500);
        })
        .catch(err => {
          console.log(err);
        });
    },
    //刷新保留数据
    loadData() {
      let get = data => JSON.parse(sessionStorage.getItem(data));
      for (let index = 1; index <= this.sum; index++) {
        let storage = get("n" + index);
        if (storage == null) {
          continue;
        }
        if (index <= this.rN) {
          let data = this.radioData[index - 1];
          data.content = storage[0];
          data.A = storage[1];
          data.B = storage[2];
          data.C = storage[3];
          data.D = storage[4];
          data.trueAnswer = storage[5];
          data.analysis = storage[6];
        } else if (index <= this.rN + this.mN) {
          let data = this.multipleData[index - this.rN - 1];
          data.content = storage[0];
          data.A = storage[1];
          data.B = storage[2];
          data.C = storage[3];
          data.D = storage[4];
          data.trueAnswer = storage[5].split("");
          data.analysis = storage[6];
        } else {
          let num = this.rN + this.mN;
          let data = this.judgeData[index - num - 1];
          data.content = storage[0];
          data.trueAnswer = storage[1];
          data.analysis = storage[2];
        }
      }
    }
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
.question {
  height: 500px;
  position: relative;

  /deep/ .ivu-radio-wrapper {
    font-size: 14px;
    margin-right: 10px;
  }

  /deep/ .ivu-checkbox-group {
    display: inline-block;

    /deep/ .ivu-radio-wrapper {
      font-size: 14px;
      margin-right: 10px;
    }
    /deep/ .ivu-checkbox + span {
      margin-left: 4px;
    }
  }

  .footPage {
    width: 51%;
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
}
.hidden {
  display: none;
}
</style>
