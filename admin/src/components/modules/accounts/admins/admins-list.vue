<template>
    <admin-results store="admins" :config="config">
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
export default createListComponent(['name', 'email'], 'admins')
</script>

<style lang="scss">
@import "~scss/_settings.scss";
</style>

