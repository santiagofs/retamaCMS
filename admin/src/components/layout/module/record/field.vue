<style lang="scss">
@import "~scss/_settings.scss";

.field {
  .help {
    font-size: .9rem;
  }
}
</style>

<template>
  <div class="field">
    <label class="label" v-if="label">{{label}}</label>
    <div class="control has-icons-right">
      <slot></slot>
      <input v-if="useDefault" ref="defaultInput" :type="useDefault" :name="name" :value="value" @input="onInput" class="input" />
      <field-status class="icon is-right" :status="$v.$dirty ? ($v.$invalid ? 'error' : 'success') : null" />
    </div>
    <p class="help is-danger"  v-if="errorMessage">{{errorMessage}}</p>
    <div class="help">
       <slot name="help"></slot>
    </div>
  </div>
</template>

<script>
import fieldStatus from './field-status'
import messages from './error-messages'

export default {
  name: 'Field',
  components: {'field-status': fieldStatus},
  data () {
    return {
      useDefault: false
    }
  },
  props: ['label', 'name', 'validation', 'messages', 'value'],
  computed: {
    status () {
      if (this.field.$invalid && !this.field.$error) return 'info'
      if (!this.field.$invalid) return 'success'
      if (this.field.$error) return 'error'
    },
    errorMessage () {
      if (!this.$v.$error) return ''
      const errors = Object.keys(this.$v.$params).filter(k => {
        return this.$v[k] === false;
      })
      const error = errors[0]
      console.log(error)
      return (this.messages && this.messages[error]) || messages(this.$v)
    }
  },
  methods: {
    onInput () {
      this.$v.$touch()
      this.$emit('input', this.$refs.defaultInput.value)
    }
  },
  created () {
    if (!this.name) {
      this.$v = {}
      return
    }
    const $v = this.$parent.validation || {}
    this.$v = $v[this.name] || this.validation || {}
    if (!this.$slots.default) this.useDefault = 'text'
  }
}
</script>

