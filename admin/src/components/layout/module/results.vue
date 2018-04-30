<style lang="scss">
@import "~scss/_settings.scss";

.results {
  height: 100%;
  // overflow: hidden;
  display: flex;
  flex-direction: column;
  padding: 0px $gap;
  .results_header {
    flex-shrink: 0;

    .results_bulk_pagination {
      display: flex;
      .results_bulk, .results_pagination {
        flex: 1 0;
        .results_pagination {
          text-align: right;
        }
      }
    }
  }
  .results_footer {
    flex-shrink: 0;
  }

  .results_body {
    width: 100%;
    flex: 2 auto;
    // height: calc(100% - 100px);
    overflow: hidden;
    border: 1px solid #DDD;
    border-radius: 4px;
    // box-shadow: 2px 2px 2px rgba(0,0,0,.2);
    position: relative;

    .no-records {
      text-align: center;
      padding: $gap*2;
      color: #999;
    }
    .results-list {
      width: 100%;
      overflow: hidden;
      position: absolute;
      left: 0; top: 0; right: 0; bottom: 0;
      border-collapse: collapse;
      border: none;
      display: flex;
      flex-direction: column;

      thead {
        display: block;
        flex-shrink: 0;
        height: 40px;
        width: 100%;
        overflow: auto;
        padding-right: 16px;
        border-bottom: 1px solid #DDD;
        overflow: hidden;
      }
      tbody {
        display: block;
        width: 100%;
        // height: calc(100% - 30px);
        overflow-y: scroll;


        tr {
           background: #FDFDFD;
          transition: all .3s ease-in-out;
          &:nth-child(2n) {
            background: #F6F6F6;
          }
          &:hover {
            background: #F0F0F0;
          }
        }
      }
      tr {
        display: flex;
        align-items: center;
      }
      th,td {
        flex: 1 0;
        padding: $gap/2 $gap;
        text-align: left;
        line-height: 1;

        &.selectable {
          width: 40px;
          flex-grow: 0;
          flex-shrink: 1;
          flex-basis: 0%;
        }
        &.actions {
          flex-grow: 0;
          flex-shrink: 0;
          flex-basis: 88px;
          white-space: nowrap;
        }
      }

    }

  }
}
</style>

<template>
    <div class="results">
      <header class="results_header">
        <div class="results_filter">
          <slot name="filters"></slot>
        </div>
        <div class="level">
          <div class="results_bulk level-left">
            <slot name="bulk"></slot>
            <bulk :bulk="bulk" v-if="bulk" />
          </div>
          <div class="results_pagination level-right">
            <slot name="top-pager"></slot>
            <pager :pager="topPager"  v-if="topPager" />
          </div>
        </div>
      </header>

      <div class="results_body">
        <p class="no-records" v-if="!records.length">No records found</p>
        <table class="results-list" v-if="records.length">
          <thead>
            <tr>
              <th v-if="config.selectable" class="selectable">
                <checkbox @click.native="toggleAll" :value="selectAll" />
              </th>
              <th-header v-for="(field, index) in config.fields" :key="index"
                :field="field" :sort="sort" @onSort="onSort"
              />
              <th v-if="hasActions" class="actions">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <record v-for="record in records" :key="record.id"
              :config="config" :record="record" :store="store" />
          </tbody>
        </table>
      </div>

      <footer class="results_footer level">
        <div class="results_info level-left">
          <slot name="info"></slot>
          <info :info="info" v-if="info" />
        </div>
        <div class="results_pagination level-right">
          <slot name="bottom-pager"></slot>
          <pager :pager="bottomPager" v-if="bottomPager" />
        </div>
      </footer>
    </div>

</template>

<script>
import record from './results/record'
import pager from './results/pager'
import info from './results/info'
import bulk from './results/bulk'
import header from './results/header'

export default {
  name: 'Results',
  components: {record, pager, info, bulk, 'th-header': header},
  props: {
    store: {default: null},
    config: {}
  },
  data () {
    return {

    }
  },
  computed: {
    records () {
      if (!this.store) return []
      return this.$store.state[this.store].records
    },
    hasActions () {
      return this.config.editable || this.config.deletable
    },
    selectAll () {
      return this.$store.state[this.store].selectAll
    },
    sort () {
      return this.$store.state[this.store].query.sort
    },
    topPager () {
      return this.$slots['top-pager'] ? null : (this.store ? this.$store.state[this.store].pager : null)
    },
    bottomPager () {
      return this.$slots['bottom-pager'] ? null : (this.store ? this.$store.state[this.store].pager : null)
    },
    info () {
      return this.$slots['info'] ? null : (this.store ? this.$store.state[this.store].info : null)
    },
    bulk () {
      return this.$slots['bulk'] ? null : 'test'
    }
  },
  methods: {
    toggleAll (value) {
      this.$store.dispatch(this.store + '/toggleAll', value)
    },
    onSort (fieldname) {
      this.$store.dispatch(this.store + '/sort', fieldname)
    },
    onDelete (msg) {
      // if (this.config.deletable) this.config.deletable()
    }
  }
}
</script>

