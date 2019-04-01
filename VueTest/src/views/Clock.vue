<template>
  <div>
    <div class="clock">
      <ul class="mark">
        <li v-for="time in 12" :key="time">{{time}}</li>
      </ul>
      <ul class="circle">
        <li v-for="n in 60" :key="n"></li>
      </ul>
    </div>
    <div class="hand-wrap">
      <div class="hand-hour"></div>
      <div class="hand-minute"></div>
      <div class="hand-second"></div>
    </div>
  </div>
</template>
<script>
export default {
  name: "clock",
  mounted() {
    var li = document.getElementsByTagName("li");
    for (let index = 0; index < 12; index++) {
      const element = li[index];
      element.style.transform = "rotate(" + (index + 1) * 30 + "deg)";
    }

    // 画表盘小线段
    const qs = sel => document.querySelector(sel);
    var cricleli = qs(".circle").children;
    for (let i = 0; i < 60; i++) {
      let li = cricleli[i];
      li.style.transform = "rotate(" + i * 6 + "deg)";
      if (i % 5 == 0) {
        li.style.height = "10px";
        li.style.width = "3px";
        li.style.backgroundColor = "red";
      }
    }

    // 获取当前 delay 的秒数
    const current = new Date();
    const ss = -1 - current.getSeconds();
    const ms = ss - current.getMinutes() * 60;
    const hs = ms - (current.getHours() % 12) * 3600;
    
    // 当前指针的指向角度，用 animation-delay 实现
    qs(".hand-second").style.animationDelay = `${ss}s`;
    qs(".hand-minute").style.animationDelay = `${ms}s`;
    qs(".hand-hour").style.animationDelay = `${hs}s`;
  }
};
</script>

<style lang="less" scoped>
@width: 300px;
@height: 300px;

.clock {
  width: @width;
  height: @height;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  border-radius: 50%;
  border: 1px solid red;
  box-shadow: 0 0 0 3px green, 0 0 2px 5px purple, 0 0 2px 5px goldenrod;
}

.resrt() {
  list-style: none;
  margin: 0;
  padding: 0;
}

.mark {
  .resrt();

  li {
    position: absolute;
    top: 10px;
    left: 48%;
    width: 10px;
    height: 20px;
    transform-origin: 55% 700%;
  }
}

ul.circle {
  width: @width;
  height: @height;
  position: relative;
  .resrt();
  li {
    width: 1px;
    height: 3px;
    position: absolute;
    left: 149px;
    top: 0px;
    transform-origin: 1px 150px;
    background-color: #000000;
  }
}

.hand-wrap {
  position: absolute;
  width: @width;
  height: @height;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

  &:before {
    content: "";
    z-index: 50;
    display: block;
    position: absolute;
    left: 149px;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 15px;
    height: 15px;
    background: silver;
    border-radius: 50%;
  }

  .hand-hour {
    width: 1px;
    height: 60px;
    position: absolute;
    left: 147px;
    top: 90px;
    transform-origin: 3px bottom;
    z-index: 40;
    border-left: 5px solid green;
    animation: round linear infinite 43200s;
  }

  .hand-minute {
    width: 1px;
    height: 100px;
    position: absolute;
    left: 148px;
    top: 50px;
    transform-origin: 2px bottom;
    z-index: 30;
    border-left: 3px solid red;
    animation: round linear infinite 3600s;
  }

  .hand-second {
    width: 1px;
    height: 130px;
    position: absolute;
    left: 149px;
    top: 20px;
    transform-origin: 1px bottom;
    z-index: 20;
    border-left: 1px solid blue;
    animation: round steps(60, end) infinite 60s;
  }
}
@keyframes round {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>
