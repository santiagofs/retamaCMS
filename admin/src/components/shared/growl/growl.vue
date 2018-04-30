<template>
  <ul class="growl-list">
    <transition-group name="list" tag="li">
      <growl-item v-for="item in items" :key="item.key" :item="item" />
    </transition-group>
    <li></li>
  </ul>
</template>

<script>
import store from './store'
import item from './item'

export default {
  name: 'growl',
  components: {'growl-item': item},
  computed: {
    items () {
      return this.$store.state.growl.items
    }
  },
  created () {
    if (!this.$store) return false
    if (!this.$store.state.growl) {
      this.$store.registerModule('growl', store)
    }
  }
}
</script>

<style lang="scss">
.growl-list {
  position: fixed;
  bottom: 20px; left: 20px;
  z-index: 2000;
}

.list-enter-active, .list-leave-active {
  transition: all 1s;
}
.list-enter {
  opacity: 0;
}
.list-leave-to  {
  opacity: 0;
  transform: translateX(-100%);
}
.list-move {
  transition: transform 1s;
}
// .list-leave-active {
//   position: absolute;
// }
</style>
