import Vue from 'vue'
import * as Helper from './helpers'
import { HTTP } from '@/main/http'
import { deleteConfirm } from '@/main/alerts'

export const createState = () => {
  return {
    query: {
      sort: null,
      filter: {},
      page: 1
    },
    pager: {
      first: 1,
      prev: 0,
      current: 0,
      next: 0,
      last: 1
    },
    info: {
      per_page: 0,
      total: 0,
      from: 0,
      to: 0
    },
    records: [],
    selectAll: false
  }
}

export function applyResponse (state, resp) {
  state.pager.current = resp.current_page
  state.pager.last = resp.last_page
  state.pager.prev = Math.max(resp.current_page - 1, 1)
  state.pager.next = Math.min(resp.current_page + 1, resp.last_page)

  state.records = resp.data

  state.info.from = resp.from
  state.info.to = resp.to
  state.info.per_page = resp.per_page
  state.info.total = resp.total
}

export const queryToParams = (query) => {
  const params = {
    sort: query.sort,
    page: query.page,
    ...query.filter
  }
  return {
    params
  }
}

export const mutations = {
  selectAll (state, value) {
    state.selectAll = value
  },
  selectRecord (state, payload) {
    Vue.set(state.records[payload.ndx], 'selected', payload.value)
  },
  setFilter (state, filter) {
    state.query.filter = filter
  },
  setSort (state, fieldname) {
    state.query.sort = fieldname
  },
  setPage (state, page) {
    state.query.page = page
  },
  setListResponse (state, p) {
    applyResponse(state, p)
  }
}


export const actions = {
  toggleAll ({commit, dispatch, state}) {
    let value = !state.selectAll
    commit('selectAll', value)
    for (let i = 0; i < state.records.length; i++) {
      commit('selectRecord', {ndx: i, value})
    }
  },
  toggleRecord ({commit, state}, payload) {
    const ndx = state.records.findIndex(e => {
      return e.id === payload.id
    })
    let value = !state.records[ndx].selected
    commit('selectRecord', {ndx, value})

    const selected = state.records.filter(e => {
      return e.selected
    })
    const all = selected.length === state.records.length
    if (state.selectAll !== all) commit('selectAll', all)
  },
  filter ({commit, dispatch, state}, filter) {
    commit('setFilter', filter)
    dispatch('fetchAll')
  },
  sort ({commit, dispatch, state}, fieldname) {
    commit('setSort', fieldname)
    dispatch('fetchAll')
  },
  page ({commit, dispatch, state}, page) {
    commit('setPage', page)
    dispatch('fetchAll')
  },
  fetchAll ({commit, state}, query) {
    commit('layout/block', null, {root: true})
    const params = queryToParams(state.query)
    HTTP().get(state.baseEndpoint, params)
      .then(res => {
        // commit('setList', res)
        commit('setListResponse', res)
        commit('layout/unblock', null, {root: true})
      })
      .catch(error => {
        commit('setListResponse', {data: [], total: 0})
        commit('layout/unblock', null, {root: true})
        Helper.handleErrorResponse(error)
      })
  },
  deleteSome ({commit, dispatch, state}, ids) {
    Array.isArray(ids) || (ids = [ids])
    deleteConfirm().then(() => {
      HTTP().delete(state.baseEndpoint + '/' + ids.join(','))
        .then(res => {
          commit('layout/block', null, {root: true})
          dispatch('fetchAll', null)
        })
        .catch(error => {
          commit('layout/unblock', null, {root: true})
          Helper.handleErrorResponse(error)
        })
    })
  }
}

export const getters = {
  selectedRecords (state) {
    if (!state.records) return []
    return state.records.filter(record => record.selected)
  }
}

export default (baseRoute, baseEndpoint) => {
  const state = {
    ...createState(),
    baseRoute,
    baseEndpoint
  }

  return {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
  }
}
