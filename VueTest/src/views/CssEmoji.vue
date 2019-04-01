<template>
  <div class="cssEmoji">
    <div id="center">
      <div class="round">
        <div class="mouth"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "cssEmoji"
};
</script>

<style lang="less" scoped>

@head-color: #ffc107;
@features-color: #5c3a13;

.eye() {
  content: "";
  position: absolute;
  height: 25px;
  width: 15px;
  top: 45px;
  border-radius: 50%;
  background-color: @features-color;
  animation: move-face 5s ease-in-out infinite,
             eyes-blink 2s ease-in-out infinite;
  animation-direction: alternate;
}
#center {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: space-around;
  margin-top: 40px;
  background: linear-gradient(
    to top,
    rgba(255, 255, 255, 1) 0%,
    rgba(255, 255, 255, 0) 100%
  );
  .round {
    height: 150px;
    width: 150px;
    margin-top: 150px;
    border: 1px solid @head-color;
    border-radius: 50%;
    background: @head-color;
    box-shadow: 0 5px 5px rgba(31, 28, 28, 0.73);
    position: relative;
    &::after {
      .eye();
      left: 40px;
    }

    &::before {
      .eye();
      left: 95px;
    }
  }
  .mouth {
    position: absolute;
    top: 15px;
    left: 0;
    right: 0;
    height: 110px;
    width: 95px;
    margin: 0 auto;
    border-bottom: 14px solid @features-color;
    border-radius: 50%;
    animation: move-face 5s ease-in-out infinite;
    animation-direction: alternate;
  }
}
@keyframes eyes-blink {
  0% {
    height: 25px;
  }
  97% {
    height: 25px;
  }
  100% {
    height: 0;
  }
}
@keyframes move-face {
  0% {
    transform: translateX(0);
  }
  35% {
    transform: translateX(10px);
  }
  70% {
    transform: translateX(-10px);
  }
  85% {
    transform: translateX(0px);
  }
  100% {
    transform: translateX(0);
  }
}
</style>
