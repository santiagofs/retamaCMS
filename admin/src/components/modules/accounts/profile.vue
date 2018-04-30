<style lang="scss">
@import "~scss/_settings.scss";
</style>

<template>
  <div>
    <h1>Profile</h1>
    <div class="">

    </div>
  </div>

</template>

<script>
import { mapState } from 'vuex'
// import { store } from '@/store'

export default {
  name: 'Profile',
  data () {
    return {

    }
  },
  computed: {
    ...mapState({
      username: state => {
        return state.accounts.name
      }
    })
  }
}
</script>

