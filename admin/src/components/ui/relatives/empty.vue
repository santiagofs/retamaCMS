<template>
  <div class="relative empty" @click="onClick">
      <span class="text">Add {{relativeType}}</span>
  </div>
</template>

<script>
export default {
  name: 'RelativeEmpty',
  props: {
    relativeType: {default: 'child'}
  },
  methods: {
    onClick () {
      this.$emit('addRelative')
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
.empty {
    cursor: pointer;
    border-style: dashed;
    border-color: #CCC;
    .text {
      width: 100%;
      left: 50%; top: 50%;
    }
}
</style>
