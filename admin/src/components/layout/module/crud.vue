<template>
  <admin-module :title="title" :subtitle="subtitle">
    <transition name="fade">
      <keep-alive include="List">
        <router-view/>
      </keep-alive>
    </transition>
    <template slot="actions">
       <router-link tag="a" :to="newRoute" class="button" v-if="mode === 'list'">{{newTitle}}</router-link>
       <router-link tag="a" :to="listRoute" class="button" v-if="mode !== 'list'">Back to list</router-link>
    </template>
  </admin-module>

</template>

<script>

const capitalize = (s) => {
  return s && s.charAt(0).toUpperCase() + s.slice(1)
}
const pluralize = (s) => {
  return s && (s + 's')
}

export default {
  name: 'Admins',
  props: ['singular', 'plural', 'route'],
  computed: {

    mode () {
      return this.$route.name.indexOf('list') !== -1 ? 'list' : (this.$route.params.id === '0' ? 'new' : 'edit')
    },
    title () {
      return (this.plural || capitalize(pluralize(this.singular)))
    },
    subtitle () {
      const mod = capitalize(this.singular)
      return this.mode === 'list' ? 'List' : (this.mode === 'new' ? `New ${mod}` : `Edit ${mod}`)
    },
    newRoute () {
      return `/${this.route}/0`
    },
    newTitle () {
      const mod = capitalize(this.singular)
      return `Add new ${mod}`
    },
    listRoute () {
      return `/${this.route}/`
    }
  }
}
</script>

<style lang="scss">
@import "~scss/_settings.scss";
</style>
