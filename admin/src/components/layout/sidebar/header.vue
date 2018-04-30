<template>
  <header class="nav-header is-clearfix">
    <div class="dropdown usermenu" :class="{'is-active': active}" v-click-outside="hideMenu">
      <div class="dropdown-trigger">
        <button class="" @click="active = !active">
          <span>Hello {{ username}}</span>
          <chevron-down class="chevron" />
          <!-- <icon :icon="chevronDown" class="chevron"></icon> -->
        </button>
      </div>

      <div class="dropdown-menu" id="dropdown-menu" role="menu">
        <div class="dropdown-content">
          <router-link tag="a" to="/profile" class="dropdown-item">Profile</router-link>
          <hr class="dropdown-divider">
          <a class="dropdown-item" @click="doLogOut">Sign Out</a>
        </div>
      </div>
    </div>
    <div>
      <span class="pinit" @click="pin">
        <pinIt v-if="!pinned" />
        <unPinIt v-if="pinned" />
      </span>
    </div>
  </header>
</template>

<script>
import ClickOutside from 'vue-click-outside'
import { mapState } from 'vuex'
import chevronDown from 'icons/chevron-down'
import pinIt from 'icons/pin'
import unPinIt from 'icons/pin-off'

export default {
  name: 'Header',
  data () {
    return {active: false}
  },
  components: { chevronDown, pinIt, unPinIt },
  directives: {
    ClickOutside
  },
  methods: {
    doLogOut: function () {
      this.$store.dispatch('user/doLogOut', {
        router: this.$router
      })
    },
    hideMenu () {
      this.active = false
    },
    pin () {
      this.$store.dispatch('layout/pin')
    }
  },
  computed: {
    ...mapState({
      username: state => {
        // console.log(state.user)
        return state.user.name
      }
    }),
    pinned () {
      return this.$store.state.layout.pinned
    }
  }
}
</script>

<style lang="scss" scoped>
@import "~scss/_settings.scss";
.nav-header {
  box-sizing: border-box;
  height: 56px;
  padding: $gap $gap $gap 0;
  background-color: transparent;
  display: flex;

  .avatar-holder {
      display: block;
      height: 80px;
      width: 80px;
      overflow: hidden;
      border-radius: 100%;
      padding: 0px;
      margin-bottom: $gap;
      float: right;
  }
  .usermenu {
    margin-left: 46px;
    font-size: 1rem;
    width: 100%;

    button {
      font-size: 1rem;
      border: none;
      border-radius: 4px;
      background: transparent;
      color: #FFF;
      cursor: pointer;
      padding-top: 4px;
      // padding-left: $gap;
      float: right;
    }
    .dropdown-content {
      width: 250px;
      padding: 0;
      // background-color: $aside-color;
      background-color:rgba(0,0,0, .9);
      box-shadow: $box-shadow;
      margin-left: -14px;
    }
    .dropdown-divider {
      margin: 0;
      background-color: $primary;
    }
    .dropdown-item {
      font-size: 1rem;
      border-left: 4px solid transparent;
      color: #FFF;
      &:hover {
        border-color: $primary;
        background: none;
        color: $primary;
      }
    }
  }
  .dropdown-trigger {
    button {
      display: flex;
    }
    .chevron {
      width: 18px;
      height: 18px;
      display: inline-block;
      fill: #FFF;
    }
  }
  .pinit {
    fill: #FFF;
    cursor: pointer;
  }
}
</style>


