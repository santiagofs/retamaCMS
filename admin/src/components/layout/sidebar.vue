<template>
  <div id="aside-container" :class="{collapsed: !expanded}">
    <handle @click="expand" />
    <sidebar-header />
    <sidebar-menu @itemClick="navigate" />
    <!-- <button @click="test">test</button> <button @click="shuffle">Shuffle</button> -->
  </div>
</template>

<script>
import handle from './sidebar/handle'
import Header from './sidebar/header'
import Menu from './sidebar/menu'

export default {
  name: 'Sidebar',
  components: {
    handle,
    'sidebar-header': Header,
    'sidebar-menu': Menu
  },
  data () {
    return {
      collapsed: true,
      catalogExpanded: false,
      testValue: true,
      testCount: 0
    }
  },
  computed: {
    expanded () {
      return this.$store.state.layout.expanded
    },
    pinned () {
      return this.$store.state.layout.pinned
    }
  },
  methods: {
    expand () {
      this.$store.commit('layout/expand')
    },
    navigate () {
      if (!this.pinned) this.expand()
    },
    test () {
      this.testValue = !this.testValue
      this.testCount += 1
      console.log('test', this.$store.state)
      // this.testValue ? this.$store.commit('layout/block') : this.$store.commit('layout/unblock')
      // this.$store.commit('growl/addItem', {text: 'hola', mode: 'is-info'})
      this.$store.dispatch('growl/success', 'this is the message ' + this.testCount)
      // this.$store.commit('layout/alert', {
      //   title: 'confirm algo',
      //   body: 'this is the body',
      //   accept: {
      //     caption: 'Accept',
      //     action: () => {

      //     }
      //   }
      // })
    },
    shuffle () {
      this.$store.commit('growl/shuffle')
    }
  }
}
</script>

<style lang="scss" scoped>
@import "~scss/_settings.scss";

#aside-container {
  position: fixed;
  width: $sidebar-width;
  height: 100vh;
  right: 0;
  top: 0;
  z-index: 1000;
  background: url('../../assets/texture.png');
  transition: all 0.5s ease-in-out;
  transform: translate(0, 0);
  box-shadow: -2px 2px 2px 0px rgba(0,0,0,.2);

  .handle {
    position: absolute;
    left: -35px;
    top: 10px;
    transition: all 0.5s ease-in-out;
    transform: translate(100%, 0);
    z-index: 20;
    box-shadow: none;
  }
  &.collapsed {
    transform: translate(100%, 0);
    box-shadow: 0px 0px 0px 0px rgba(0,0,0,.2);
    .handle {
      transform: translate(0, 0);
      box-shadow: -2px 2px 2px 0px rgba(0,0,0,.2);

    }
  }
}
</style>

