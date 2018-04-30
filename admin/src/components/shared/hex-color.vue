<style lang="scss">
@import "~scss/_settings.scss";
.hex-color {
  display: flex;
  align-items: center;
  .hex-color__sample {
      width: 36px; height: 36px;
  box-shadow: inset 0 1px 2px rgba(10, 10, 10, 0.1);
  border-color: #DBDBDB;
  margin-right: $gap/2;
  border-radius: 3px;
  }
  .disabled {
    width: 130px;
    padding-left: 10px;
  }
  input {
    width: 130px;
  }
}
</style>

<template>
  <div class="hex-color">
    <div class="hex-color__sample" :style="{backgroundColor: value}"></div>
    <div class="disabled" v-if="disabled">{{value}}</div>
    <input v-if="!disabled" type="text" :name="name" class="input" :value="value" @input="onInput" @focus="active = true" @blur="checkHash" />
  </div>
</template>

<script>
import { withParams } from 'vuelidate/lib'
import {req} from 'vuelidate/lib/validators/common'

export const isHex = withParams({ type: 'isHex' }, value => {
  return !req(value) || /^#[0-9A-F]{6}$/i.test(value) || /^#[0-9A-F]{3}$/i.test(value)
})

export default {
  name: 'HexColor',
  components: {},
  directives: {},
  props: {value: {default: '#FFFFFF'}, name: '', disabled: false},
  data () {
    return {}
  },
  computed: {},
  methods: {
    hidePicker () {
      this.active = false
    },
    onInput (e) {
      this.$emit('input', e.target.value)
    },
    checkHash (e) {
      if (e.target.value.indexOf('#') !== 0) e.target.value = '#' + e.target.value
      this.onInput(e)
    }
  }
}


</script>
