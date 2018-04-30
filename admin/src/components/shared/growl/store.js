const state = {
  items: []
}

const mutations = {
  addItem (state, item) {
    item.key = new Date().getTime()
    state.items.push(item)
  },
  removeItem (state, item) {
    const ndx = state.items.findIndex(e => e === item)
    state.items.splice(ndx, 1)
  },
  shuffle (state) {
    state.items.push(state.items.shift())
  }
}

const actions = {
  addItem ({commit}, item) {
    item.timeout = setTimeout(function () {
      commit('removeItem', item)
    }, 5000)
    commit('addItem', item)
  },
  success ({dispatch}, text) {
    const item = {text, mode: 'is-success'}
    dispatch('addItem', item)
  },
  warning ({dispatch}, text) {
    const item = {text, mode: 'is-warning'}
    dispatch('addItem', item)
  },
  danger ({dispatch}, text) {
    const item = {text, mode: 'is-danger'}
    dispatch('addItem', item)
  },
  info ({dispatch}, text) {
    const item = {text, mode: 'is-info'}
    dispatch('addItem', item)
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
