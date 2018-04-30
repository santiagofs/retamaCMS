<template>
  <div id="children">
    <relative-you />
    <relative-set />
  </div>
</template>

<script>
import RelativeYou from './relatives/you'
import RelativeEmpty from './relatives/empty'
import Relative from './relatives/relative'
import RelativeSet from './relatives/set'

export default {
  name: 'Children',
  components: {
    'relative-you': RelativeYou,
    'relative-empty': RelativeEmpty,
    'relative': Relative,
    'relative-set': RelativeSet
  },
  data () {
    return {
      msg: ''
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.relative.you {
  margin: auto;
}
</style>
