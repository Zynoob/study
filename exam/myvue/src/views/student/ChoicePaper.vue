<template>
  <div class="choice_paper">
    科目：
    <Select v-model="subject_id" style="width:100px" @on-change="choicePaper">
      <Option v-for="item in subjectList" :value="item.id" :key="item.id">{{ item.name }}</Option>
    </Select>
    <Table border :columns="table_columns" :data="table_data" no-data-text="空空的,这里一无所有..."></Table>
    <div class="footPage">
      <Page
        id="pageId"
        :total="sum"
        show-elevator
        :current="currentPage"
        :page-size="5"
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
  name: "choice_paper",
  data() {
    return {
      table_columns: [
        {
          title: "序号",
          type: "index",
          width: 60,
          align: "center"
        },
        {
          title: "试卷标题",
          key: "title",
          align: "center",
          render: (h, params) => {
            return h("div", [h("strong", params.row.title)]);
          }
        },
        {
          title: "试卷编号",
          key: "paper_id",
          align: "center",
          render: (h, params) => {
            return h("div", [h("strong", params.row.paper_id)]);
          }
        },
        {
          title: "得分",
          key: "totalScore",
          align: "center",
          render: (h, params) => {
            return h("div", [h("strong", params.row.totalScore)]);
          }
        },
        {
          title: "考试时长",
          key: "duration",
          align: "center",
          render: (h, params) => {
            return h("div", [h("strong", params.row.duration + " min")]);
          }
        },
        {
          title: "Action",
          key: "action",
          width: 150,
          align: "center",
          render: (h, params) => {
            return h("div", [
              h(
                "Button",
                {
                  props: {
                    type: "primary",
                    size: "small"
                  },
                  style: {
                    marginRight: "5px"
                  },
                  on: {
                    click: () => {
                      this.show(params.index);
                    }
                  }
                },
                "开始考试"
              )
            ]);
          }
        }
      ],
      table_data: [],
      subjectList: [],
      currentPage: 1, //当前页
      sum: 0,
      subject_id: ""
    };
  },
  methods: {
    show(index) {
      this.$Modal.confirm({
        title: "考试",
        content: `<div>是否选择序号${index+1}的<br>
        <${this.table_data[index].title}><br>进行考试？</div>`,
        onOk: () => {
          this.$router.push({
            path: "exam",
            query: {
              id: this.table_data[index].paper_id
            }
          });
        }
      });
    },
    changePage(newpage) {
      //无数据，返回
      if (this.sum == 0) {
        return;
      }
      let offset = (newpage - 1) * 5;
      this.$mypost("/api/stu/choice_paper.php", {
        id: this.subject_id,
        offset
      })
        .then(rep => {
          // console.log(rep);
          this.sum = rep.data.dataRows;
          if (rep.data.status == 0) {
            this.$Message.error("查询出现错误");
            return;
          }
          this.table_data = rep.data.info;
        })
        .catch(err => {
          console.log(err);
        });
      this.currentPage = newpage;
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
    // 初始化科目列表
    initSubjectList() {
      this.$mypost("/api/admin/get_subject.php")
        .then(result => {
          // console.log(result);
          this.subjectList = result.data.subject;
        })
        .catch(err => {
          console.log(err);
        });
    },
    choicePaper(id) {
      // console.log(id);
      this.$mypost("/api/stu/choice_paper.php", {
        id
      })
        .then(rep => {
          // console.log(rep);
          this.sum = rep.data.dataRows;
          if (rep.data.status == 0) {
            this.$Message.error("查询出现错误");
            return;
          }
          this.table_data = rep.data.info;
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
.choice_paper {
  width: 100%;
  height: 100%;
  overflow-y: scroll;

  .footPage {
    width: 50%;
    position: absolute;
    bottom: 10%;
    margin-left: 20%;
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
}
</style>
