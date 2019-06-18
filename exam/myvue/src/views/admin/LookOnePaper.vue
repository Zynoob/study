<template>
  <div class="look_one_paper">
    <ul class="serch_ul">
      <li class="serch_li">
        <Input
          v-model="id"
          search
          enter-button
          placeholder="通过id搜索..."
          style="width:200px"
          @on-search="searchPaper(id)"
        />
      </li>
    </ul>
    <br>
    <div style="textAlign:left;">
      <div class="cell">
        <Input v-model="subjectName" disabled placeholder="科目名...."/>
      </div>
    </div>
    <Table
      border
      max-height="400"
      stripe
      :columns="table_columns"
      :data="table_data"
      :loading="isLoading"
      no-data-text="未找到试卷的信息"
    ></Table>
  </div>
</template>

<script>
import expandRow from "../../components/TableExpand.vue";

export default {
  name: "lookOnePaper",
  data() {
    return {
      id: "",
      subjectName: "",
      isLoading: false,
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
                "View"
              ),
              h(
                "Button",
                {
                  props: {
                    type: "error",
                    size: "small"
                  },
                  on: {
                    click: () => {
                      this.remove(params.index);
                    }
                  }
                },
                "Delete"
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
      table_data: []
    };
  },
  methods: {
    async searchPaper(id = "") {
      let response;
      this.isLoading = true;
      try {
        response = await this.$mypost("/api/admin/look_one_paper.php", {
          id: id
        });
      } catch (error) {
        this.$Message.error("网络连接中断");
        this.id = "";
        return;
      }

      // console.log(response);
      if (response.data.status == 0 || response.data.status == 1) {
        this.isLoading = false;
      }
      if (response.data.status != 1) {
        this.$Message.error(response.msg);
        this.id = "";
        return;
      }
      this.table_data = response.data.info;
      this.subjectName = response.data.subjectName;
      this.id = "";
      sessionStorage.setItem("paper_data", JSON.stringify(response.data));
    },
    loadData() {
      let data = JSON.parse(sessionStorage.getItem("paper_data"));
      if (data == null) {
        return;
      }
      this.table_data = data.info;
      this.subjectName = data.subjectName;
    }
  },
  created() {
    this.loadData();
  },
  beforeRouteLeave(to, from, next) {
    sessionStorage.removeItem("paper_data");
    next();
  }
};
</script>


<style lang="less">
.look_one_paper {
  .serch_ul {
    text-align: left;
    .serch_li {
      display: inline-block;
      &:first-child {
        margin-right: 20px;
      }
    }
  }

  .cell {
    text-align: left;
    display: inline-block;

    .ivu-input {
      text-align: center;
      &::placeholder {
        text-align: center;
      }
    }
  }
}
</style>
