// import {HTTP} from './../../../main/http'

const state = {
  block: false,
  alert: null,
  pinned: false,
  expanded: false
}

const mutations = {
  block (state) {
    state.block = true
  },
  unblock (state) {
    state.block = false
  },
  alert (state, config) {
    state.alert = config
  },
  unalert (state) {
    state.alert = null
  },
  pin (state, value) {
    state.pinned = value !== undefined ? value : !state.pinned
  },
  expand (state, value) {
    state.expanded = value !== undefined ? value : !state.expanded
  }
}

const actions = {
  pin ({commit, state}) {
    if (state.pinned) commit('expand', false)
    commit('pin')
  }
}

const getters = {

}
export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
