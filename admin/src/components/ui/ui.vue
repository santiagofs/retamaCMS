<template>
  <div id="UI">
    <children v-if="step==='children'"></children>
  </div>
</template>

<script>
import children from './children'
export default {
  name: 'Ui',
  components: {
    children: children
  },
  data () {
    return {
      step: 'children'
    }
  }
}
</script>

<style lang="scss">

#UI {
  font-family: 'Roboto Condensed', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
@import 'vars.scss';

.relative-container {
  width: 120px; height: 100px;
  position: relative;
}
.relative {
  box-sizing: border-box;
  width: $relative-size;
  height: $relative-size;
  border-radius: 100%;
  border: $connector-size solid $connector-color;
  margin: 0 ($relative-gap / 2);
  position: relative;
  background: #FFF;
  .text, .age, .gender, .diagnosis {
    position: absolute;
    transform: translate(-50%, -50%);
    font-size: 18px;
    font-weight: bold;

    &.default {
      color: #CCC
    }
  }
  .text {
    left: 50%; top: 50%;
  }
  .age {
    left: 30%; top: 75%;
  }
  .gender {
    left: 50%; top: 25%;
  }
  .diagnosis {
    left: 70%; top: 75%;
  }
}

.connector {
  box-sizing: border-box;
  // fill: $connector-color;
  // stroke-width: $connector-size;
  //fill: $connector-color;
  stroke: $connector-color;
  stroke-width: 4;
  display: block;
  margin: auto;

  // &.join-horizontal {
  //   height: $connector-size;
  //   position: relative;
  //   left: 50%; top: 50%;
  //   transform: translate(-50%, 0)
  // }
  // &.connector-vertical {
  //   height: $relative-size / 8;
  //   width: $connector-size;
  //   border: none;
  // }
}
</style>
