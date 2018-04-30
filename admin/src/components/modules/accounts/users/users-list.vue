<template>
    <admin-results store="users" :config="config">
      <list-filter slot="filters" @onFilter="onFilter()" @onReset="onFilter()" :query="query">
        <div class="control">
          <input class="input" type="text" v-model="query.name" placeholder="name">
        </div>
        <div class="control">
          <input class="input" type="text" v-model="query.email" placeholder="email">
        </div>
      </list-filter>
    </admin-results>
</template>

<script>
import { createListComponent } from '@/main/crud/results-helper'
export default createListComponent(['name', 'email'], 'users')

// import listFilter from '@/components/layout/module/results/filter'
// import * as helper from '@/main/crud/results-helper'

// export default {
//   name: 'List',
//   components: {'list-filter': listFilter},
//   data () {
//     return {
//       ...helper.createData(['name', 'email'], 'users')
//     }
//   },
//   methods: {
//     onFilter: helper.createOnFilter('users')
//   },
//   activated: helper.createActivated('users')
// }
</script>

<style lang="scss">
@import "~scss/_settings.scss";
</style>

