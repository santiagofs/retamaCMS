<style lang="scss">
@import "~scss/_settings.scss";

#ui-block {
  position: fixed;
  top: 56px; bottom: 0;
  left: 0; right: 0;
  background: rgba(0,0,0,.4);
  z-index: 500;
  display: flex;
  justify-content: center;
  align-items: center;
  padding-bottom: 4rem;
  .centered {
    color: #FFF;
    text-align: center;
    text-shadow: 2px 2px 2px rgba(0,0,0,.2);
    .spin {
      svg {
        width: 4rem;
        height: 4rem;
        fill: $saffron;
      }


    }
    .text {
      font-size: 1.4rem;
    }
  }
}

.spin {
  svg {
     animation: spin 1s 0s infinite linear;
  }

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



</style>


<template>
  <transition name="fade">
    <div id="ui-block" v-if="show">
      <div class="centered">
        <!-- <icon :icon="spinner" spin /> -->
        <loading class="spin" />
        <div class="text">Please, wait</div>
      </div>
    </div>
  </transition>
</template>

<script>

import loading from 'icons/loading'

export default {
  name: 'Sidebar',
  components: {loading},
  data () {
    return {
      spinner: {d: 'M456.433 371.72l-27.79-16.045c-7.192-4.152-10.052-13.136-6.487-20.636 25.82-54.328 23.566-118.602-6.768-171.03-30.265-52.529-84.802-86.621-144.76-91.424C262.35 71.922 256 64.953 256 56.649V24.56c0-9.31 7.916-16.609 17.204-15.96 81.795 5.717 156.412 51.902 197.611 123.408 41.301 71.385 43.99 159.096 8.042 232.792-4.082 8.369-14.361 11.575-22.424 6.92z'}
    }
  },
  computed: {
    show () {
      return this.$store.state.layout.block
    }
  }
}
</script>

