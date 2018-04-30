<style lang="scss" scoped>
  .checkbox {
    width: 20px;
    height: 20px;
    display: inline-block;
    vertical-align: middle;

    .icon-checked {
      display: none;
    }
    &.checked {
      .icon-unchecked {
        display: none;
      }
      .icon-checked {
        display: inline;
      }
    }
  }
</style>


<template>
  <a class="checkbox" :class="{checked: value}">
    <!-- <transition name="fade"> -->
      <unchecked class="icon-unchecked" />
      <checked class="icon-checked" />
    <!-- </transition> -->
  </a>
</template>

<script>
import unchecked from 'icons/checkbox-blank-outline'
import checked from 'icons/checkbox-marked-outline'

export default {
  name: 'checkbox',
  components: {unchecked, checked},
  props: {
    value: {default: false}
  },
  methods: {
    onClick () { this.$emit('click', !this.value) }
  }
}
</script>

