<template>
  <div class="growl-item" :class="[mode]" @click="remove"> {{ text }} </div>
</template>

<script>


export default {
  name: 'growl-item',
  props: ['item'],
  computed: {
    text () { return this.item ? this.item.text : '' },
    mode () { return this.item ? this.item.mode : 'is-info' }
  },
  methods: {
    remove () {
      this.$store.commit('growl/removeItem', this.item)
    }
  }
}
</script>

<style lang="scss">
@import "~scss/_settings.scss";
.growl-item {
  width: 200px;
  background: #FFF;
  // border: 1px solid #FFF;
  border-radius: 4px;
  padding: 5px 10px;
  margin-bottom: 10px;
  cursor: pointer;
  box-shadow: 1px 1px 1px rgba(0,0,0,.3);
  font-size: 14px;

  &.is-info {
    background: $info;
    color: #FFF;
  }
  &.is-danger {
    background: $danger;
    color: #FFF;
  }
  &.is-success {
    background: $success;
    color: #FFF;
  }
  &.is-warning {
    background: $warning;
    color: #FFF;
  }
}
</style>



