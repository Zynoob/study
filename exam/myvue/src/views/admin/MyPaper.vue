<template>
  <div class="admin_mypaper">
    <div style="textAlign:left;width:200px">
      <Input v-model="subjectName" disabled placeholder="科目名...."/>
    </div>
    <Table border :columns="table_columns" :data="table_data" no-data-text="空空的,这里一无所有..."></Table>
  </div>
</template>

<script>
import expandRow from "../../components/TableExpand.vue";
export default {
  name: "admin_mypaper",
  data() {
    return {
      subjectName: "",
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
    show(index) {
      this.$Modal.info({
        title: "未制作",
        content: `非常抱歉，${index}这只是个摆设<br>这只是个摆设...`
      });
    },
    remove(index) {
      //试卷标题与试卷编号
      let title = this.table_data[index].title;
      let paper_id = this.table_data[index].paper_id;
      let vm = this;
      this.$Modal.confirm({
        title: "删除试卷",
        content: "是否删除试卷<" + title + ">",
        loading: true,
        onOk: deletePaper
      });
      function deletePaper() {
        let id = paper_id;
        vm.$mypost("/api/admin/delete_paper.php", {
          id
        })
          .then(rep => {
            if (rep.data.status == 0) {
              vm.$Modal.remove();
              vm.$Message.error(rep.msg);
              return;
            }
            vm.$Message.success("删除成功");
            vm.$Modal.remove();
            vm.table_data.splice(index, 1);
            // console.log(rep);
            // console.log(id);
          })
          .catch(err => {
            console.log(err);
          });
      }
    },
    getData() {
      this.$mypost("/api/admin/myPaper.php")
        .then(rep => {
          // console.log(data);
          if (rep.data.status == 0) {
            this.$Message.error("查询出现错误");
            return;
          }
          this.table_data = rep.data.info;
          this.subjectName = rep.data.subjectName;
        })
        .catch(err => {
          console.log(err);
        });
    }
  },
  created() {
    this.getData();
  }
};
</script>

<style lang="less">
.admin_mypaper {
  width: 100%;
  height: 100%;
}
</style>
