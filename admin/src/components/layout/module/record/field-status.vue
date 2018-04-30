<style lang="scss">
@import "~scss/_settings.scss";

.field-status {
  display: flex;
  .material-design-icon {
    height: 24px;
    &.check-icon {
      svg {
        fill: $success;
      }
    }
    &.alert-circle-outline-icon {
      svg {
        fill: $danger;
      }
    }
  }
}
</style>

<template>
    <div class="field-status">
      <transition>
        <checkIcon v-if="status === 'success'" />
        <errorIcon v-if="status === 'error'" />
      </transition>
    </div>
</template>

<script>
import checkIcon from 'icons/check'
import errorIcon from 'icons/alert-circle-outline'


export default {
  name: 'field-status',
  components: {checkIcon, errorIcon},
  data () {
    return {}
  },
  props: ['status']
}
</script>

