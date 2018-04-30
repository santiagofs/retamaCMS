import Vue from 'vue'
import Vuex from 'vuex'

import layout from '@/components/layout/store'
import user from '@/components/modules/accounts/store'
import admins from '@/components/modules/accounts/admins/store'
import users from '@/components/modules/accounts/users/store'
// import content from '@/components/modules/content/store'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    layout,
    user,
    admins,
    users
  }
})
