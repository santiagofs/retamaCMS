<template>
  <span class="isvg">
    <span class="ratio"></span>
    <svg :class="[{'spin': spin}, {'pulse': pulse}]" xmlns="http://www.w3.org/2000/svg" :viewBox="viewBox"><path :d="icon.d"/></svg>
  </span>
</template>
<script>
import { search } from './index'

export default {
  name: 'Icon',
  props: {
    spin: {type: Boolean},
    pulse: {type: Boolean},
    icon: {default: search}
  },
  computed: {
    viewBox () {
      // console.log(this.icon, viewBoxes[this.icon])
      return this.icon.v !== undefined ? this.icon.v : '0 0 512 512'
    }
  }
}
</script>
<style scoped lang="scss">
  .isvg {
    display: inline-block;
    position: relative;

    // display: flex;
    // justify-content: center;
    // align-items: center;

    color: inherit;
    width: 1.5rem;
    .ratio {
      display: block;
      padding-top: 100%;

    }
    svg {
      position: absolute;
      left: 50%; top:50%;
      transform: translate(-50%, -50%);
      fill: currentColor;
    }


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
