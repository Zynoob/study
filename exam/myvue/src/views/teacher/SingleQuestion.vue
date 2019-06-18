<template>
  <div class="SingleQuestion">
    <Tabs v-model="name">
      <TabPane label="单选题" name="单选题">
        <form id="form1">
          题干
          <span style="color:red">*</span>：
          <Input
            v-model="radioData.content"
            type="textarea"
            placeholder="试题内容"
            :rows="3"
            style="width: 400px"
            @on-blur="inputTrim('radioData','content')"
          />
          <br>
          <br>
          <div class="cell">
            选项A:
            <Input
              v-model="radioData.A"
              type="textarea"
              placeholder="这是A"
              :rows="2"
              style="width: 300px"
              @on-blur="inputTrim('radioData','A')"
            />
          </div>
          <div class="cell">
            选项B:
            <Input
              v-model="radioData.B"
              type="textarea"
              placeholder="这是B"
              :rows="2"
              style="width: 300px"
              @on-blur="inputTrim('radioData','B')"
            />
          </div>
          <br>
          <div class="cell">
            选项C:
            <Input
              v-model="radioData.C"
              type="textarea"
              placeholder="这是C"
              :rows="2"
              style="width: 300px"
              @on-blur="inputTrim('radioData','C')"
            />
          </div>
          <div class="cell">
            选项D:
            <Input
              v-model="radioData.D"
              type="textarea"
              placeholder="这是D"
              :rows="2"
              style="width: 300px"
              @on-blur="inputTrim('radioData','D')"
            />
          </div>
          <br>
          <br>
          <div style="fontSize:14px">
            正确答案：
            <RadioGroup v-model="radioData.trueAnswer">
              <Radio label="A"></Radio>
              <Radio label="B"></Radio>
              <Radio label="C"></Radio>
              <Radio label="D"></Radio>
            </RadioGroup>
            <span style="marginLeft:10px">
              分值：
              <Input
                v-model="radioData.score"
                type="number"
                placeholder="Enter something..."
                style="width: 100px"
                @on-blur="radioData.score=verifyScore(radioData.score)"
              />
            </span>
          </div>
          <br>解析：
          <Input
            v-model="radioData.analysis"
            type="textarea"
            placeholder="解析*"
            :autosize="{ minRows: 2, maxRows: 4 }"
            style="width: 400px"
            @on-blur="inputTrim('radioData','analysis')"
          />
        </form>
      </TabPane>
      <TabPane label="多选题" name="多选题">
        <form id="form2">
          题干
          <span style="color:red">*</span>：
          <Input
            v-model="multipleData.content"
            type="textarea"
            placeholder="试题内容"
            :rows="3"
            style="width: 400px"
            @on-blur="inputTrim('multipleData','content')"
          />
          <br>
          <br>
          <div class="cell">
            选项A:
            <Input
              v-model="multipleData.A"
              type="textarea"
              placeholder="这是A"
              :rows="2"
              style="width: 300px"
              @on-blur="inputTrim('multipleData','A')"
            />
          </div>
          <div class="cell">
            选项B:
            <Input
              v-model="multipleData.B"
              type="textarea"
              placeholder="这是B"
              :rows="2"
              style="width: 300px"
              @on-blur="inputTrim('multipleData','B')"
            />
          </div>
          <br>
          <div class="cell">
            选项C:
            <Input
              v-model="multipleData.C"
              type="textarea"
              placeholder="这是C"
              :rows="2"
              style="width: 300px"
              @on-blur="inputTrim('multipleData','C')"
            />
          </div>
          <div class="cell">
            选项D:
            <Input
              v-model="multipleData.D"
              type="textarea"
              placeholder="这是D"
              :rows="2"
              style="width: 300px"
              @on-blur="inputTrim('multipleData','D')"
            />
          </div>
          <br>
          <br>
          <div style="fontSize:14px">
            正确答案：
            <CheckboxGroup v-model="multipleData.trueAnswer">
              <Checkbox label="A"></Checkbox>
              <Checkbox label="B"></Checkbox>
              <Checkbox label="C"></Checkbox>
              <Checkbox label="D"></Checkbox>
            </CheckboxGroup>
            <span style="marginLeft:10px">
              分值：
              <Input
                v-model="multipleData.score"
                type="number"
                placeholder="Enter something..."
                style="width: 100px"
                @on-blur="multipleData.score=verifyScore(multipleData.score)"
              />
            </span>
          </div>
          <br>解析：
          <Input
            v-model="multipleData.analysis"
            type="textarea"
            placeholder="解析*"
            :autosize="{ minRows: 2, maxRows: 4 }"
            style="width: 400px"
            @on-blur="inputTrim('multipleData','analysis')"
          />
        </form>
      </TabPane>
      <TabPane label="判断题" name="判断题">
        <form id="form3">
          题干：
          <span style="color:red">*</span>：
          <Input
            v-model="judgeData.content"
            type="textarea"
            placeholder="试题内容"
            :rows="4"
            style="width: 400px"
            @on-blur="inputTrim('judgeData','content')"
          />
          <br>
          <br>
          <div style="fontSize:14px">
            正确答案：
            <RadioGroup v-model="judgeData.trueAnswer">
              <Radio label="t">True</Radio>
              <Radio label="f">False</Radio>
            </RadioGroup>
            <span style="marginLeft:10px">
              分值：
              <Input
                v-model="judgeData.score"
                type="number"
                placeholder="Enter something..."
                style="width: 100px"
                @on-blur="judgeData.score=verifyScore(judgeData.score)"
              />
            </span>
          </div>
          <br>解析：
          <Input
            v-model="judgeData.analysis"
            type="textarea"
            placeholder="解析*"
            :autosize="{ minRows: 4, maxRows: 6 }"
            style="width: 400px"
            @on-blur="inputTrim('judgeData','analysis')"
          />
        </form>
      </TabPane>
    </Tabs>
    <div class="upload">
      <ButtonGroup>
        <Button type="primary" @click="submit(name)" style="marginRight:25px">
          <Icon type="md-create"/>提交
        </Button>
        <Button type="primary" @click="toTeacherPage()">
          返回
          <Icon type="ios-undo"/>
        </Button>
      </ButtonGroup>
    </div>
  </div>
</template>

<script>
export default {
  name: "SingleQuestion",
  data() {
    return {
      radioData: {
        content: "",
        A: "",
        B: "",
        C: "",
        D: "",
        trueAnswer: "",
        analysis: "",
        score: 0
      },
      multipleData: {
        content: "",
        A: "",
        B: "",
        C: "",
        D: "",
        trueAnswer: [],
        analysis: "",
        score: 0
      },
      judgeData: {
        content: "",
        trueAnswer: "",
        analysis: "",
        score: 0
      },
      name: "单选题"
    };
  },
  mounted() {},
  methods: {
    //去除首尾空格
    inputTrim(obj = "", name = "") {
      this[obj][name] = this[obj][name].trim();
    },
    //处理分值
    verifyScore(num) {
      let score = Math.round(num);
      if (score < 0) {
        this.$Message.error("分值不能小于0");
        return 0;
      }
      if (score > 100) {
        this.$Message.error("分值超过100，设置过大");
        return 0;
      }
      return score;
    },
    //数据清空
    initData() {
      this.radioData = {
        content: "",
        A: "",
        B: "",
        C: "",
        D: "",
        trueAnswer: "",
        analysis: "",
        score: 0
      };
      this.multipleData = {
        content: "",
        A: "",
        B: "",
        C: "",
        D: "",
        trueAnswer: [],
        analysis: "",
        score: 0
      };
      this.judgeData = {
        content: "",
        trueAnswer: "",
        analysis: "",
        score: 0
      };
    },
    submit(name) {
      let obj = { name };
      switch (name) {
        case "单选题":
          obj = Object.assign({}, obj, this.radioData);
          break;
        case "多选题":
          {
            let trueAnswer = {
              trueAnswer: this.multipleData.trueAnswer.join("")
            };
            obj = Object.assign({}, obj, this.multipleData, trueAnswer);
          }
          break;
        case "判断题":
          obj = Object.assign({}, obj, this.judgeData);
          break;
      }
      let arr = Object.values(obj);
      if (arr.some(val => val == 0)) {
        this.$Message.warning("请填写完整");
        return;
      }
      this.$mypost("/api/tea/singleQuestion.php", {
        question: obj
      })
        .then(data => {
          // console.log(data);
          if (data.data.status == 1) {
            this.$Message.success("成功创建试题");
          }
          this.initData();
        })
        .catch(err => {
          console.log(err);
        });
    }
  }
};
</script>

<style lang="less">
.SingleQuestion {
  height: 500px;
  position: relative;

  .cell {
    box-sizing: border-box;
    width: 40%;
    display: inline-block;
    margin: 10px;
  }

  .ivu-checkbox-group {
    display: inline-block;

    .ivu-radio-wrapper {
      font-size: 14px;
      margin-right: 10px;
    }
    .ivu-checkbox + span {
      margin-left: 4px;
    }
  }

  .upload {
    position: absolute;
    bottom: 5px;
    left: 0;
    right: 0;
  }
}
</style>
