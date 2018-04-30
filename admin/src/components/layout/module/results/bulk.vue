<style lang="scss" >
@import "~scss/_settings.scss";
  .bulk {
    .select select {
      &:focus {
        border: 1px solid #DBDBDB;
        outline: none;
        box-shadow: none;
      }
    }
  }
</style>

<template>
  <div class="bulk">
    <div class="field has-addons">
      <div class="control">
        <div class="select">
          <select v-model="selectedAction">
            <option value="" v-if="!selectedAction">[ Select a bulk action]</option>
            <option v-for="(value, key) in actions" :value="key" :key="value">{{ value }}</option>
          </select>
        </div>
        <!-- <input class="input" type="text" placeholder="Find a repository"> -->
      </div>
      <div class="control">
        <button class="button is-info" :disabled="!selectedAction" @click="doAction">
          Do
        </button>
      </div>
    </div>

  </div>
</template>

<script>
import * as Alerts from '@/main/alerts'

export default {
  name: 'bulk',
  props: ['bulk', 'store'],
  data () {
    return {
      selectedAction: ''
    }
  },
  computed: {
    actions () {
      return {deleteAll: 'Delete all selected'}
    },
    storeName () {
      return this.store || this.$parent.store || null
    }
  },
  methods: {
    deleteAll () {

    },
    doAction () {
      if (!this.storeName) return console.log('bulk actions store not set')
      const selected = this.$store.getters[this.storeName + '/selectedRecords'].map(r => {
        return r.id
      })
      if (!selected.length) {
        Alerts.nothingSelected()
        return false
      }
      this.$store.dispatch(this.storeName + '/deleteSome', selected)
      // this.$emit('onBulkAction', this.selectedAction)
    }
  }

}
</script>
