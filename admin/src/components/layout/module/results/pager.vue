<style lang="scss" >
@import "~scss/_settings.scss";

.pager {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: $gap 0;
  button {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #DDD;
    border-radius: 4px;
    transition: all .3s ease-in-out;
    color: $primary;
    margin: 0px $gap/4;
    cursor: pointer;
    &:first-child {
      margin-left: 0;
    }
    &:last-child {
      margin-right: 0;
    }
    &:not(:disabled):hover {
      background: #FFF;
      border-color: $primary;
    }
    .material-design-icon {

      height: 24px;
      svg {
        height: 24px;
      }
    }
    &:disabled {
      pointer-events: none;
      cursor: default;
      text-decoration:none;
      color:#DDD;
      fill: #DDD;
    }
  }
  .page {
    margin: 0 $gap/2;
    color: #000;
  }

}

// .prev, .next {
//   // background: #F00;
//   .isvg {
//     height: 24px;
//     svg {
//       height: 24px;
//     }
//   }
// }
</style>

<template>
  <div class="pager">
    <button class="first" :disabled="firstDisabled" @click="navigate(pager.first)"><firstIcon /></button>
    <button class="prev" :disabled="prevDisabled" @click="navigate(pager.prev)"><prevIcon /></button>
    <div class="page"><span>{{currentPage}}</span></div>
    <button class="next" :disabled="nextDisabled" @click="navigate(pager.next)"><nextIcon /></button>
    <button class="last" :disabled="lastDisabled" @click="navigate(pager.last)"><lastIcon /></button>
  </div>
</template>

<script>
import firstIcon from 'icons/page-first'
import lastIcon from 'icons/page-last'
import prevIcon from 'icons/chevron-left'
import nextIcon from 'icons/chevron-right'

export default {
  name: 'pager',
  props: ['pager', 'store'],
  components: {firstIcon, lastIcon, prevIcon, nextIcon},
  data () {
    return {}
  },
  computed: {
    currentPage () {
      return this.pager.current
    },
    firstDisabled () {
      return this.pager.current === 1
    },
    prevDisabled () {
      return this.pager.current === 1
    },
    nextDisabled () {
      return this.pager.current === this.pager.next
    },
    lastDisabled () {
      return this.pager.current === this.pager.last
    },
    storeName () {
      return this.store || this.$parent.store || null
    }
  },
  methods: {
    navigate (page) {
      if (!this.storename) return console.log('pager store not set')
      this.$store.dispatch(this.storename + '/page', page)
      this.$emit('onNavigate', page)
    }
  }
}
</script>
