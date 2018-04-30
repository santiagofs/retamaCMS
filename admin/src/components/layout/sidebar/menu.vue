<template>
  <ul id="aside-menu">

    <template v-for="item in userItems">
      <router-link v-if="!item.sep"
        :key="item.to"
        tag="li" :to="item.to" :class="['menu-item', item.text.toLowerCase()]"
        @click.native="onClick"
      >
        <span class="menu-item_content">
          <component :is="item.icon" class="menu-item_icon"></component>
          <span class="menu-item_text">{{item.text}}</span>
        </span>

        <ul class="submenu" v-if="item.children.length > 0">
          <router-link
            v-for="child in item.children" :key="child.to"
            tag="li" :to="child.to" :class="['menu-item', child.text.toLowerCase()]"
            @click="onClick"
          >
            <span class="menu-item_content">
              <!-- <span class="menu-item_icon"></span> -->
              <span class="menu-item_text">{{child.text}}</span>
            </span>
          </router-link>
        </ul>
      </router-link>
    </template>
  </ul>
</template>

<script>
/* eslint-disable object-property-newline */
import gauge from 'icons/gauge'
import content from 'icons/book-open-variant'
import translate from 'icons/translate'
import account from 'icons/account'


export default {
  name: 'Menu',
  data () {
    return {
      items: [
        {to: '/dashboard', icon: gauge, text: 'Dashboard', children: [], roles: ['super', 'admin', 'user']},
        {to: '/content', icon: content, text: 'Contenido', children: [
          {to: '/content/pages', text: 'Páginas'},
          {to: '/content/news', text: 'Noticias'},
          {to: '/content/widgets', text: 'widgets'},
          {to: '/content/productions', text: 'Producciones'}
        ], roles: ['super', 'admin']},
        {to: '/translations', icon: translate, text: 'Traducciones', children: [
          {to: '/translations/dynamic', text: 'Módulos'}
        ], roles: ['super', 'admin']},
        {to: '/accounts', icon: account, text: 'Cuentas', children: [
          {to: '/accounts/users', text: 'Usuarios'},
          {to: '/accounts/admins', text: 'Administradores'}
        ], roles: ['super', 'admin']}
      ]
    }
  },
  computed: {
    userItems () {
      // const user = this.$store.state.user
      return this.items.filter(e => {
        // return e.roles.indexOf(accounts.role) !== -1
        return true
      })
    }
  },
  methods: {
    onClick () {
      this.$emit('itemClick')
    }
  }
}
</script>

<style lang="scss" scoped>
@import "~scss/_settings.scss";

#aside-menu {
  border-top: 1px solid rgba(255,255,255,.4);
  padding: 0 0 $gap 0;

  display: flex;
  flex-direction: column;
  .menu-item {
    background-color: #2f4050;
    border-left: 4px solid transparent;
    min-height: 51px;
    cursor: pointer;

    &.providers, &.tenants {
      border-top: 1px solid #a7b1c2
    }
    .menu-item_content {
      position: relative;
      display: flex;
      padding: $gap;
      color: #a7b1c2;
      // font-weight: 600;

      .menu-item_icon {
        max-width: 20px;
        max-height: 20px;
        fill: #a7b1c2;
        display: flex;
        margin-right: $gap;
      }
      .menu-item_text {
        vertical-align: middle;
      }
    }

    &.router-link-exact-active {
      .menu-item_content {
        color: $white;
      }
    }
    .submenu {
      box-sizing: border-box;
      padding-bottom: $gap;
      .menu-item {
        margin-left: 36px;
        background: transparent;
        min-height: auto;
      }
      .menu-item_content {
        padding: $gap/2 $gap;
        a {
          color: $white;
        }
      }
    }

    &:hover, &.router-link-active {
        background: rgba(0,0,0,.3);
        border-left: 4px solid $success;
        > .menu-item_content {
            color: $white;
        }
        .menu-item_icon {
          fill: #FFF;
        }
    }
    &:hover {
      border-left: 4px solid $saffron;
    }
    &.router-link-active {
      .menu-item_icon {
        fill: $success;
      }
    }

    &:not(.router-link-active) {
        .submenu {
            height: 0;
            padding-bottom: 0px;
            overflow: hidden;
        }
    }
    &.router-link-exact-active,  {
      color: $white;
      border-left: 4px solid $success;
    }
  }

  li.separator {
    box-sizing: border-box;
    height: 1px;
    border-top: 1px solid #a7b1c2;
  }
}
</style>

