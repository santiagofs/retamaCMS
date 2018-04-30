<template>
  <tr class="record">
    <td v-if="config.selectable" class="selectable">
      <checkbox @click.native="toggleRecord(record.id, $event)" :value="record.selected" />
    </td>
    <td v-for="(td, index) in tds" :key="index">
      <span v-if="typeof td === 'string'">{{td}}</span>
      <component :is="td" v-else></component>
    </td>
    <td v-if="hasActions" class="actions">
      <router-link v-if="config.editable" :to="config.editable(record)" tag="a" class="edit-button"><pencil /></router-link>
      <a class="delete-button" @click="onDelete(record)"><trash /></a>
    </td>
  </tr>
</template>

<script>
import pencil from 'icons/pencil'
import trash from 'icons/delete'

export default {
  components: {pencil, trash},
  name: 'Record',
  props: ['config', 'record', 'store'],
  computed: {
    tds () {
      if (!this.config) return []
      const record = this.record
      return this.config.fields.map((e, i, a) => {
        return e.format ? e.format(record, e) : record[e.name]
      })
    },
    hasActions () {
      return this.config.editable || this.config.deletable
    }
  },
  methods: {
    onDelete (record) {
      // show confirmation
      this.config.deletable && this.config.deletable(record)
      this.$store.dispatch(this.store + '/deleteSome', record.id)
    },
    toggleRecord (id, value) {
      this.$store.dispatch(this.store + '/toggleRecord', {id, value})
    }
  }
}
</script>

<style lang="scss" scoped>
@import "~scss/_settings.scss";

.record {
  a {
    color: $primary;

  }
  .actions {
    padding: 0;
    display: flex;
    width: 88px;
    .isvg {
      width: 14px;
    }
    a {
      display: flex;
      // box-sizing: border-box;
      // width: 26px; height: 26px;
      border: 1px solid #DDD;
      border-radius: 4px;
      padding: 2px;
      background: #FDFDFD;
      transition: all .3s ease-in-out;
      width: 24px; height: 24px;
      // .material-design-icon {
      //  font-size: 10px;
      //  height: 10px;
      //  line-height: 10px;
      //  width: 24px;
      // }

      &:not(:first-child) {
        margin-left: $gap/2;
      }
      &.delete-button {
        color: $danger;
        fill: #999;
        &:hover {
          background: #FFF;
          border-color: $danger;
          fill: $danger;
        }
      }
      &.edit-button {
        color: $success;
        fill: #999;
        &:hover {
          background: #FFF;
          border-color: $success;
          fill: $success;
        }
      }
    }

  }

}
</style>

