<template>
  <div id="app">
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: "app",
  data() {
    return {
      msg: ""
    };
  },
  mounted() {
    setInterval(() => {
      this.$mypost("/api/save_session.php")
        .then(result => {
          let msg = result.msg;
          this.msg = msg;
          // console.log(result.msg);
        })
        .catch(() => {
          this.$router.push("/login");
        });
    }, 1000 * 60 * 20);
  }
};
</script>

<style>
#app {
  font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Helvetica, Arial,
    sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
