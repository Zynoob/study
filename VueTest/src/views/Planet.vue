<template>
  <div class="planet">
    <div class="planet-container">
      <div class="planet"></div>
    </div>
  </div>
</template>

<script>
export default {
  name: "planet"
};
</script>

<style lang="less" scoped>
.planet-container {
  background: linear-gradient(150deg, #5f2093, rgba(35, 35, 35, 0), rgba(35, 35, 35, 0));
  position: absolute;
  left: 50%;
  top: 50%;
  height: 200px;
  width: 200px;
  padding: 20px;
  border-radius: 50%;
  transform: translate(-50%, -50%);
  animation: jump 6s cubic-bezier(0.445, 0.05, 0.55, 0.95) infinite;
}
.planet-container .planet {
  border-radius: 50%;
  width: 100%;
  background: linear-gradient(180deg, #a37dce, #5f2093, rgba(35, 35, 35, 0));
  height: 100%;
}
.planet-container .planet:after {
  content: "";
  display: block;
  position: absolute;
  width: 300px;
  height: 40px;
  top: 90px;
  left: -40px;
  border-radius: 100%;
  border-top: 10px solid transparent;
  border-bottom: 10px solid #c099ef;
  border-left: 10px solid #c099ef;
  border-right: 10px solid #c099ef;
  transform: rotate(20deg);
}
.planet-container .planet:before {
  content: "";
  display: block;
  position: absolute;
  height: 40px;
  top: 90px;
  left: -40px;
  border-radius: 100%;
  border-top: 10px solid transparent;
  border-bottom: 10px solid #c099ef;
  border-left: 10px solid #c099ef;
  border-right: 10px solid #c099ef;
  transform: rotate(20deg);
  z-index: -1;
  width: 300px;
  border-top: 10px solid #c099ef;
}
.planet-container:after {
  content: "";
  display: block;
  position: relative;
  top: -185px;
  left: 65px;
  height: 10px;
  width: 10px;
  border-radius: 10px;
  background-color: rgba(255, 255, 255, 0.8);
}
.planet-container:before {
  content: "";
  display: block;
  position: relative;
  border-radius: 5px;
  top: 40px;
  left: 30px;
  height: 10px;
  width: 30px;
  background-color: rgba(255, 255, 255, 0.8);
  transform: rotate(-40deg);
}
@keyframes jump {
  0% {
    top: 50%;
  }
  50% {
    top: 45%;
  }
  100% {
    top: 50%;
  }
}

</style>
