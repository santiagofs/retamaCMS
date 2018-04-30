<style lang="scss">
@import "~scss/_settings.scss";

.results__header {
  display: flex;
  align-items: center;

  .material-design-icon {
    width: 18px;
    height: 18px;
    svg {
      width: 18px;
      height: 18px;
      margin-left: $gap/2;
      fill: #999;
    }
  }
  &.active {
    .material-design-icon {
      svg {
        fill: #333;
      }
    }
  }
}

</style>

<template>
  <th :class="['results__header', {active: isMe}]">
    <a @click="onClick()">{{field.label}}</a> <component :is="icon" />
  </th>
</template>

<script>
import sortIcon from 'icons/sort'
import ascIcon from 'icons/sort-ascending'
import descIcon from 'icons/sort-descending'

export default {
  name: 'resultsHeader',
  components: {sortIcon, ascIcon, descIcon},
  props: {field: {default: {}}, sort: {default: ''}},
  computed: {
    parsedSort () {
      let ret = {mode: '-', field: ''}
      if (!this.sort) return ret

      let mode = this.sort.substring(0, 1)
      if (mode === '-' || mode === '+') {
        ret.mode = mode
        ret.field = this.sort.slice(1)
      } else {
        ret.mode = '-'
        ret.field = this.sort
      }
      return ret
    },
    isMe () {
      return this.parsedSort.field === this.field.name
    },
    icon () {
      return !this.isMe ? sortIcon : (this.parsedSort.mode === '+' ? ascIcon : descIcon)
    }
  },
  methods: {
    onClick () {
      let fieldname = ''
      if (!this.isMe) {
        fieldname = '+' + this.field.name
      } else {
        const mode = this.parsedSort.mode === '-' ? '+' : '-'
        fieldname = mode + this.field.name
      }
      this.$emit('onSort', fieldname)
    }
  }
}
</script>
