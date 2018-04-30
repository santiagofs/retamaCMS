<template>
  <div class="colors-form">
    <field label="Primary color" name="primary" :validation="$v.colors.primary">
      <hex-color v-model="colors.primary" @input="$v.colors.primary.$touch()" />
    </field>

    <field label="Secondary color" name="secondary" :validation="$v.colors.secondary">
      <hex-color v-model="colors.secondary" @input="$v.colors.secondary.$touch()" />
    </field>

    <field label="Highlight color" name="highlight" :validation="$v.colors.highlight">
      <hex-color v-model="colors.highlight" @input="$v.colors.highlight.$touch()" />
    </field>

    <field label="Text color" name="text" :validation="$v.colors.text">
      <hex-color v-model="colors.text" @input="$v.colors.text.$touch()" />
    </field>

    <field label="Background color" name="background" :validation="$v.colors.background">
      <hex-color v-model="colors.background" @input="$v.colors.background.$touch()" />
    </field>
  </div>
</template>

<script>
import HexColor from '@/components/shared/hex-color'

export default {
  name: 'ColorsForm',
  components: {'hex-color': HexColor},
  props: {colors: {default: {}}},
  created () {
    const $v = this.$parent.validation || {}
    this.$v = $v[this.name] || this.validation || {}
  }
</script>

<style lang="scss">
@import "~scss/_settings.scss";

</style>