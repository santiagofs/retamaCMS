<style lang="scss">
@import "~scss/_settings.scss";
.field {
  position: relative;
  .color-picker {
    position: absolute;
    right: -$gap/2; top: 0;
    transform: translate(100%, 0);
    display: none;
    &.active {
      display: block;
    }
  }
}
</style>

<template>
   <field :label="label" :name="name" v-click-outside="hidePicker" :validation="v">
      <div class="color-field">
        <div class="color-sample" :style="{backgroundColor: value}"></div>
        <input type="text" :name="name" class="input" :value="value"
          @input="onInput"
          @focus="active = true"
        />
      </div>
      <chrome-picker v-model="pickerColor" class="color-picker" :class="{active}" />
      <p></p>
    </field>

</template>

<script>
import field from '@/components/layout/module/record/field'
import { Chrome } from 'vue-color'
import ClickOutside from 'vue-click-outside'

export default {
  name: 'ColorField',
  components: {'chrome-picker': Chrome, field},
  directives: {ClickOutside},
  props: {label: {}, name: {}, value: {default: '#FFFFFF'}, v: {}},
  data () {
    return {
      active: false
    }
  },
  computed: {
    pickerColor: {
      get () {
        return this.value
      },
      set (value) {
        this.$emit('input', value.hex)
      }
    }
  },
  methods: {
    hidePicker () {
      this.active = false
    },
    onInput (e) {
      this.$emit('input', e.target.value)
    }
  }
}
</script>
