<template>
  <div id="site-wrapper" :class="{'sidebar-expanded': sidebarExpanded, 'sidebar-pinned': sidebarPinned}">
    <pop-alert />
    <growl />

    <header id="site-header">
        <div class="isologotipo">
          <!-- <img class="isotipo" src="@/assets/mgt-logo.png" />  -->
          <span class="logotipo">Retama CMS</span>
        </div>
    </header>

    <div id="site-content">
      <ui-block></ui-block>
      <transition name="fade">
        <router-view/>
      </transition>
    </div>

    <sidebar />

  </div>
</template>

<script>
import Sidebar from './sidebar.vue'
import UiBlock from './ui-block.vue'
import popAlert from './pop-alert'

export default {
  name: 'Auth',
  components: {
    'sidebar': Sidebar,
    'ui-block': UiBlock,
    'pop-alert': popAlert
  },
  computed: {
    sidebarPinned () {
      return this.$store.state.layout.pinned
    },
    sidebarExpanded () {
      return this.$store.state.layout.expanded
    },
    user () {
      return this.$store.state.user
    },
    logo () {
      return this.$store.state.user.logo ? 'url(' + this.$store.state.user.logo + ')' : ''
    }
  },
  methods: {
    // toggleSidebar () {
    //   this.sidebarCollapsed = !this.sidebarCollapsed
    // }
  }
}
</script>

<style lang="scss">
@import "~scss/_settings.scss";

#site-wrapper {
  height: 100vh;
  overflow: hidden;
  background: #FDFDFD;
  transition: padding-right 0.5s ease-in-out;

  &.sidebar-pinned.sidebar-expanded {
    padding-right: $sidebar-width;
    #site-header .level-right {
      padding-right: 0px;
    }
  }

  #site-header {
    padding: 0 $gap;
    height: 56px;
    box-shadow: 2px 2px 2px 0px rgba(0,0,0,.2);
    background: $light;
    background: $success;
    margin-bottom: 0px;
    display: flex;
    align-items: center;

    .company-info {
      display: flex;
      align-items: center;
      .company-logo {
        height: 50px; width: 50px;
        margin-right: 10px;
        background-size: contain;
        background-position: center center;
        background-repeat: no-repeat;
      }
    }

    #site-logo {
      height: 40px;
      display: inline-block;
      img {
        max-width: 100%; max-height: 100%;
      }
    }

    .level-right {
      padding-right: 30px;
      transition: padding-right 0.5s ease-in-out;
    }



  }


  #site-content {
    height: calc(100vh - 56px);
    padding: $gap*2 0 0 ;
  }

  &.sidebar-collapsed {
    padding-right: 0px;
    #site-aside {
        right: -$sidebar-width;
    }
  }
}
.logotipo {
  color: #FFF;
  font-size: 18px;
  border-radius: 4px;
  padding: 8px 16px;
  // background: url('../../assets/texture.png');

  .serif {
    font-family: sans-serif
  }
  .sans {
    font-family: sans-serif;
    text-transform: uppercase;
    color: $primary;
  }
  margin-right: $gap/2;
}
.isotipo {
  height: 30px;
  margin-right: $gap/2;
}
.isologotipo {
  display: flex;
  align-items: center;
}
</style>
