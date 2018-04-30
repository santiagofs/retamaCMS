<template>
  <svg :class="['icon', {'spin': spin}, {'pulse': pulse}]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path :d="icon"/></svg>
</template>
<script>
import search from './icons/search'

export default {
  name: 'Icon',
  props: {
    spin: {type: Boolean},
    pulse: {type: Boolean},
    icon: {default: search}
  },
  computed: {

  }
}
</script>
<style scoped>
  .icon {
    display: inline-block;
    fill: currentColor;
  }
  .flip-horizontal {
    transform: scale(-1, 1);
  }
  .flip-vertical {
    transform: scale(1, -1);
  }
  .spin {
    animation: spin 1s 0s infinite linear;
  }
  .inverse {
    color: #fff;
  }
  .pulse {
    animation: spin 1s infinite steps(8);
  }
  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }
    100% {
      transform: rotate(360deg);
    }
  }
  /* svg {fill: inherit} */
</style>
