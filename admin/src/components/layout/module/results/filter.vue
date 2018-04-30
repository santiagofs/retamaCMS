<style lang="scss" >
@import "~scss/_settings.scss";
  .filter {
    // border-bottom: 1px solid #DDD;
    // padding-bottom: $gap;
    display: flex;
    .control, button {
      margin-right: $gap;
    }
  }

</style>

<template>
  <div class="filter" ref="children">
    <slot></slot>
    <button class="button is-info" :disabled="disabled" @click="doFilter()">Filter</button>
    <button class="button is-light" @click="doReset()">Reset</button>
  </div>
</template>

<script>
export default {
  name: 'resultsFilter',
  props: ['query'],
  data () {
    return {
      selectedAction: ''
    }
  },
  computed: {
    disabled () {
      if (!this.query) return false
      for (let key of Object.keys(this.query)) {
        if (this.query[key]) return false
      }
      return true
    }
  },
  methods: {
    doFilter () {
      this.$emit('onFilter')
    },
    doReset () {
      if (this.query) {
        for (let key of Object.keys(this.query)) {
          this.query[key] = null
        }
      }
      this.$emit('onReset')
    }
  }
}
</script>
