import {HTTP} from '@/main/http'

const state = {
  allPlanOptions: [],
  userPlanOptions: [],
  logo: null,
  customization: {
    primary: '#FFFFFF',
    secondary: '#FFFFFF',
    text: '#FFFFFF',
    background: '#FFFFFF',
    highlight: '#FFFFFF'
  },
  tmpLogo: null
}

const mutations = {
  allOptions (state, payload) {
    state.allPlanOptions = payload
  },
  userOptions (state, payload) {
    state.userPlanOptions = payload
  },
  logo (state, payload) {
    state.logo = payload
  },
  tmpLogo (state, payload) {
    state.tmpLogo = payload
  },
  customization (state, colors) {
    if (!colors.primary) colors.primary = '#FFFFFF'
    if (!colors.secondary) colors.secondary = '#FFFFFF'
    if (!colors.text) colors.text = '#FFFFFF'
    if (!colors.background) colors.background = '#FFFFFF'
    if (!colors.highlight) colors.highlight = '#FFFFFF'
    state.customization = colors
  },
  toggleOption (state, payload) {
    const ndx = state.allPlanOptions.findIndex(e => {
      return e.id === payload
    })
    state.allPlanOptions[ndx].selected = !state.allPlanOptions[ndx].selected
  }
}

const actions = {
  getSettings ({ commit }, id) {
    HTTP().get('tenants/' + id + '/settings')
      .then(res => {
        const planOptions = res.planOptions.map(e => {
          e.selected = (res.userOptions.indexOf(e.id) !== -1)
          return e
        })
        commit('allOptions', planOptions)
        commit('userOptions', res.userOptions)
        commit('logo', res.logo)
        if (res.customization) commit('customization', res.customization)
      })
      .catch(err => {
        console.log(err)
      })
  },
  saveSettings ({commit, dispatch, state}, id) {
    commit('layout/block', null, {root: true})
    const record = {
      tmpLogo: state.tmpLogo,
      options: state.customization
    }
    HTTP().post('tenants/' + id + '/settings', record)
      .then(res => {
        commit('accounts/setLogo', res.logo, {root: true})
        commit('tmpLogo', '')
        commit('logo', res.logo + '?' + new Date().getTime())
        commit('layout/unblock', null, {root: true})
        dispatch('growl/success', 'Settings saved', {root: true})
      })
      .catch(err => {
        console.log(err)
      })
  }
}

const getters = {}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
