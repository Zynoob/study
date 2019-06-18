<template>
  <div class="search-of-teahcer">
    <ul class="serch_ul">
      <li class="serch_li">
        <Input
          v-model="search.id"
          search
          enter-button
          placeholder="通过id搜索..."
          style="width:200px"
          @on-search="searchStudent('id',search.id)"
        />
      </li>
      <li class="serch_li">
        <Input
          v-model="search.name"
          search
          enter-button
          placeholder="通过姓名搜索..."
          style="width:200px"
          @on-search="searchStudent('name',search.name)"
        />
      </li>
    </ul>
    <br>
    <div style="textAlign:left;">
      <div class="cell">
        <Input v-model="uname" disabled placeholder="用户名...."/>
      </div>
      <div class="cell">
        <Input v-model="uid" disabled placeholder="用户id...."/>
      </div>
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
      no-data-text="未找到该学生的信息"
    ></Table>
  </div>
</template>

<script>
import expandRow from "../../components/TableExpand.vue";

export default {
  name: "SearchOfTeahcer",
  data() {
    return {
      search: {
        name: "",
        id: ""
      },
      uname: "",
      uid: "",
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
    async searchStudent(type = "id", data = "") {
      let response;
      this.isLoading = true;
      switch (type) {
        case "id":
          try {
            response = await this.$mypost("/api/tea/query_one_student.php", {
              id: data
            });
          } catch (error) {
            this.$Message.error("网络连接中断");
            this.search = { name: "", id: "" };
            return;
          }
          break;
        case "name":
          try {
            response = await this.$mypost("/api/tea/query_one_student.php", {
              name: data
            });
          } catch (error) {
            this.$Message.error("网络连接中断");
            this.search = { name: "", id: "" };
            return;
          }
          break;
      }
      console.log(response);
      if (response.data.status == 0 || response.data.status == 1) {
        this.isLoading = false;
      }
      if (response.data.status != 1) {
        this.$Message.error(response.msg);
        this.search = { name: "", id: "" };
        return;
      }
      this.table_data = response.data.info;
      this.uid = response.data.studentId;
      this.uname = response.data.studentName;
      this.subjectName = response.data.subjectName;
      this.search = { name: "", id: "" };
      sessionStorage.setItem("student_data", JSON.stringify(response.data));
    },
    loadData() {
      let data = JSON.parse(sessionStorage.getItem("student_data"));
      if (data == null) {
        return;
      }
      this.table_data = data.info;
      this.uid = data.studentId;
      this.uname = data.studentName;
      this.subjectName = data.subjectName;
    }
  },
  created() {
    this.loadData();
  },
  beforeRouteLeave(to, from, next) {
    sessionStorage.removeItem("student_data");
    next();
  }
};
</script>

<style lang="less">
.search-of-teahcer {
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