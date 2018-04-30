<template>
  <button class="handle" @click="onClick">
    <menuIcon />
  </button>
</template>

<script>
import menuIcon from 'icons/menu'

export default {
  name: 'Handle',
  components: {
    menuIcon
  },
  methods: {
    onClick () {
      // console.log('click');
      this.$emit('click');
    }
  }
}
</script>

<style lang="scss" scoped>
@import "~scss/_settings.scss";
  .handle {
    box-sizing: border-box;
    display: flex;
    justify-content: left;
    align-items: center;
    width: 40px;

    height: 36px;
    border: none;
    border-radius: 4px;
    background: url('../../../assets/texture.png');
    color: #FFF;
    padding: 4px;
    padding-left: 5px;
    cursor: pointer;
    // transition: all 0.5s ease-in-out;
    // transform: translate(100%, 0);
    z-index: 20;
    fill: #FFF;
    .material-design-icon {
      width: 26px; height: 26px;
    }
  }
</style>

