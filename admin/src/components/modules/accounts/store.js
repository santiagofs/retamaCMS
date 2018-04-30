import {HTTP} from '@/main/http'
import jws from 'jws'

const state = {
  admin: null,
  email: null,
  id: null,
  is_admin: null,
  is_patient: null,
  is_provider: null,
  is_tenant: null,
  name: null,
  role: null,
  userable: null,
  logged: false,
  autoRefreshStarted: false,
  company: '',
  logo: '',
  loginErrorMessage: ''
}

const mutations = {
  setUser (state, payload) {
    state.logged = true
    for (let key of Object.keys(payload)) {
      state[key] = payload[key]
    }
  },
  unsetUser (state) {
    state.logged = false
    state.name = null
    state.role = null
  },
  setAutoRefresh (state) {
    state.autoRefreshStarted = true
  },
  setLogo (state, logo) {
    localStorage.setItem('logo', logo)
    state.logo = logo + '?' + new Date().getTime()
  },
  setLoginErrorMessage (state, message) {
    state.loginErrorMessage = message
  }
}

const actions = {
  doSignIn ({ commit, dispatch }, payload) {
    commit('setLoginErrorMessage', '')
    HTTP().post('login', {
      email: payload.username,
      password: payload.password
    })
      .then(res => {
        localStorage.setItem('token', res.token)
        const decoded = jws.decode(res.token).payload

        commit('setUser', decoded)
        dispatch('autoRefreshToken')

        var history = payload.router.history
        if (history.pending) return payload.router.push(history.pending.fullPath)

        return payload.router.push('/')
      })
      .catch(error => {
        commit('setLoginErrorMessage', error.response.data)
      })
  },
  restoreUser ({commit}, payload) {
    const token = localStorage.getItem('token')
    if (!token) return

    const decoded = jws.decode(token).payload
    commit('setUser', decoded)
    const logo = localStorage.getItem('logo')
    if (logo) commit('setLogo', logo)

    return true
  },
  doLogOut ({ commit }, payload) {
    HTTP().post('logout')
      .then()
      .catch(error => {
        console.log(error)
      })
    commit('unsetUser')
    localStorage.removeItem('token');
    return payload.router.push('/sign-in')
    // window.top.location.reload(true);
  },
  autoRefreshToken ({ commit, dispatch }, payload) { // autorefresh the token 1 minute before it expires
    if (state.autoRefreshStarted) return

    const token = localStorage.getItem('token')
    if (!token) return

    commit('setAutoRefresh')

    const decoded = jws.decode(token);
    const expiration = (decoded.payload.exp - decoded.payload.iat) - 60
    console.log('expiration', expiration)
    setTimeout(function () {
      HTTP().get('refresh')
        .then(res => {
          localStorage.setItem('token', res.token)
          dispatch('autoRefreshToken')
          return true
        })
        .catch(error => console.log(error))
    }, (expiration * 1000))
  }
  // checkToken ({ commit }, payload) {
  //   HTTP().get('check-token')
  //     .then(res => {
  //       return true
  //     })
  //     .catch(error => {
  //       console.log(error)
  //       commit('unsetUser')
  //       localStorage.removeItem('token');
  //       return payload.router.push('/sign-in')
  //     })
  // }
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
