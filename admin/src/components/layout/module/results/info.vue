<style lang="scss" >
@import "~scss/_settings.scss";

.info {
  color: #666;
  .from, .to, .total {
    color: $primary;
  }

}
</style>

<template>
  <div class="info">
    <span class="records"> Showing records from <span class="from">{{ info.from }}</span> to <span class="to">{{ info.to }}</span></span> <span class="totals">( total: <span class="total">{{info.total}}</span> )</span>
  </div>
</template>

<script>
export default {
  name: 'info',
  props: ['info'],
  data () {
    return {}
  },
  computed: {
  }
}
</script>
