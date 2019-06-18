<template>
  <div>
    <Row class="expand-row">
      <Col span="6">
        <span class="expand-key">单选题数量: </span>
        <span class="expand-value">{{ row.radio }}</span>
      </Col>
      <Col span="6">
        <span class="expand-key">多选题数量: </span>
        <span class="expand-value">{{ row.multiple }}</span>
      </Col>
      <Col span="6">
        <span class="expand-key">判断题数量: </span>
        <span class="expand-value">{{ row.judgement }}</span>
      </Col>
      <Col span="6">
        <span class="expand-key">试卷总分: </span>
        <span class="expand-value">{{ row.totalScore }}</span>
      </Col>
    </Row>
    <Row class="expand-row">
      <Col span="24">
        <span class="expand-key">试卷介绍: </span>
        <span class="expand-value">{{ row.content }}</span>
      </Col>
    </Row>
  </div>
</template>
<script>
export default {
  props: {
    row: Object
  }
};
</script>

<style scoped>
</style>