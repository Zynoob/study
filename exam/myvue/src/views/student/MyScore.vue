<template>
  <div class="student_score">
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
import expandRow from "../../components/TableExpand.vue";
export default {
  name: "student_score",
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
          key: "id",
          align: "center",
          render: (h, params) => {
            return h("div", [h("strong", params.row.id)]);
          }
        },
        {
          title: "得分",
          key: "score",
          align: "center",
          render: (h, params) => {
            return h("div", [h("strong", params.row.score)]);
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
          title: "Time",
          key: "time",
          align: "center"
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
                "查看解析"
              )
            ]);
          }
        },
        {
          type: "expand",
          width: 50,
          render: (h, params) => {
            return h(expandRow, {
              props: {
                row: params.row
              }
            });
          }
        }
      ],
      table_data: [],
      currentPage: 1, //当前页
      sum: 0
    };
  },
  methods: {
    show(index) {
      this.$Modal.info({
        title: "未制作",
        content: `非常抱歉，<br>序号${index +
          1}的按钮<br>这只是个摆设<br>这只是个摆设...`
      });
    },
    getData(offset) {
      this.$mypost("/api/stu/student_score.php", {
        offset
      })
        .then(rep => {
          // console.log(rep);
          if (rep.data.status == 0) {
            this.$Message.error("查询出现错误");
            return;
          }
          this.table_data = rep.data.info;
        })
        .catch(err => {
          console.log(err);
        });
    },
    changePage(newpage) {
      let offset = (newpage - 1) * 5;
      this.getData(offset);
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
    }
  },
  created() {
    this.$mypost("/api/stu/student_score.php")
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
};
</script>

<style lang="less">
.student_score {
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
