<style lang="scss">
@import "~scss/_settings.scss";

.item {
  height: 100%;
  display: flex;
  padding: 0 $gap;
  flex-direction: column;
  .item_header {
    flex-shrink: 0;
    margin-bottom: $gap/2;
  }
  .item_footer {
    margin-top: $gap/2;
    flex-shrink: 0;
  }

  .item_body {
    width: 100%;
    flex: 2 auto;
    // height: calc(100% - 100px);
    overflow: auto;
    border: 1px solid #DDD;
    border-radius: 4px;
    // box-shadow: 2px 2px 2px rgba(0,0,0,.2);
    position: relative;
    padding: $gap;
  }
  .actions {
    button {
      margin-left: $gap;
    }
  }

  h4 {
    font-size: 1.2rem;
    color: #000;
    margin: $gap 0 $gap/2;
  }
}
</style>

<template>
    <div class="item">
      <header class="item_header level">
        <div class="level-left"></div>
        <div class="level-right actions">
          <slot name="top-actions"></slot>
          <!-- <button class="button" :disabled="disabled" @click="doReset">Reset</button> -->
          <button class="button is-info" :disabled="disabled" @click="doSave">Save</button>
        </div>
      </header>
      <div class="item_body">
        <slot v-if="mode !== 'not-found'" :text="'test me'"></slot>
        <div v-if="mode === 'not-found'" class="not-found"><p>Record not found</p></div>
      </div>
      <footer class="item_footer level">
        <div class="level-left"></div>
        <div class="level-right actions">
          <slot name="top-actions"></slot>
          <!-- <button class="button" :disabled="disabled" @click="doReset">Reset</button> -->
          <button class="button is-info" :disabled="disabled" @click="doSave">Save</button>
        </div>
      </footer>

    </div>

</template>

<script>
import {pendingErrors} from '@/main/alerts'

export default {
  name: 'Item',
  components: {},
  data () {
    return {
      control: null
    }
  },
  props: {
    validation: {default: {}},
    mode: {default: 'edit'}
  },
  computed: {
    disabled () {
      if (this.mode === 'not-found') return true
      if (this.form && this.form.$invalid) return true
    },
    anyDirty () {
      return Object.keys(this.form.$params).map(e => {
        return this.form[e].$dirty
      }).indexOf(true) !== -1
    }
  },
  methods: {
    doSave () {
      this.validation.$touch()
      if (this.validation.$error) {
        pendingErrors()
      } else {
        this.$emit('onSave')
      }
    }
  }
}
</script>

