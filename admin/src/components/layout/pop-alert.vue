<style lang="scss">
@import "~scss/_settings.scss";

.pop-alert__overlay {
  position: fixed;
  top: 0px; bottom: 0;
  left: 0; right: 0;
  z-index: 2000;
  display: flex;
  justify-content: center;
  align-items: center;
  background: rgba(0,0,0,.4);
}

.pop-alert__window {
  background: #FFF;
  width: 400px;
  border-radius: 4px;
  box-shadow: 2px 2px 2px rgba(0,0,0,.2);
  padding: $gap;
  position: relative;
  border-left: $gap/2 solid $primary;
  margin-top: -20vh;

  h1 {
    font-weight: bold;
    padding-bottom: $gap/2;
    margin-bottom: $gap/2;
    border-bottom: 1px solid #DDD;
    text-align: center;
  }
  .danger & {
    border-left: $gap/2 solid $danger;
  }
  .warning & {
    border-left: $gap/2 solid $warning;
  }
  .success & {
    border-left: $gap/2 solid $success;
  }
  .info & {
    border-left: $gap/2 solid $info;
  }
}
.pop-alert__body {
  white-space: pre-wrap;
}

.close {
  padding: 5px;
  border-radius: 100%;
  position: absolute;
  top: -12px; right: -12px;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 24px; height: 24px;
  border: 1px solid #DDD;
  background: #FFF;
  .close-icon {
    width: 16px; height: 16px;
    display: flex;
    justify-content: center;
    align-items: center;
  }
}
.pop-alert__footer {
  display: flex;
  justify-content: space-between;
  margin-top: $gap * 2;
  text-align: right;
  .pop-alert__footer-cell {
    flex: 1 0 0;
    &:first-child{
      padding-right: $gap/2;
    }
    &:last-child{
      padding-left: $gap/2;
    }
  }
  button {
    width: 100%;
  }
}
</style>
<template>
  <div :class="['pop-alert', {show: true}]">
    <transition name="fade">
      <div v-if="show" :class="['pop-alert__overlay', cssClass]">
        <div class="pop-alert__window">
          <header class="pop-alert__header">
            <a class="close" @click="dismiss" v-if="dismissable"><close /></a>
            <h1 class="">{{title}}</h1>
          </header>
          <div class="pop-alert__body">
            <p>{{body}}</p>
          </div>
          <footer class="pop-alert__footer">
            <div class="pop-alert__footer-cell">
              <button class="button" @click="dismiss">{{dismissCaption}}</button>
            </div>
            <div class="pop-alert__footer-cell" v-if="isConfirm">
              <button class="button" :class="[isClass]" @click="accept" >{{acceptCaption}}</button>
            </div>
          </footer>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import close from 'icons/close'
export default {
  name: 'popAlert',
  components: {close},
  data () {
    return {
    }
  },
  computed: {
    config () {
      return this.$store.state.layout.alert ? this.$store.state.layout.alert : {}
    },
    show () {
      return this.$store.state.layout.alert !== null
    },
    title () {
      return this.config.title
    },
    body () {
      return this.config.body
    },
    cssClass () {
      return this.config.cssClass || 'primary'
    },
    isClass () {
      return 'is-' + this.cssClass
    },
    isConfirm () {
      return this.config.accept
    },
    acceptAction () {
      if ({}.toString.call(this.config.accept) === '[object Function]') return this.config.accept
      if (this.config.accept.action && {}.toString.call(this.config.accept.action) === '[object Function]') return this.config.accept.action
      return () => {}
    },
    acceptCaption () {
      return (this.config.accept && this.config.accept.caption) ? this.config.accept.caption : (this.config.captionPrimary || 'Ok')
    },
    dismissCaption () {
      return (this.config.dismiss && this.config.dismiss.caption) ?
        this.config.dismiss.caption :
        this.config.accept ? 'Cancel' : 'Ok'
    },
    dismissable () {
      return this.config.dismissable || false
    }
  },
  methods: {
    dismiss () {
      this.$store.commit('layout/unalert')
    },
    accept () {
      this.acceptAction()
      this.dismiss()
    }
  }
}
</script>
