import router from '@/main/router'
import * as Helper from './helpers'
import { HTTP } from '@/main/http'

export const createState = () => {
  return {
    record: null
  }
}

export const mutations = {
  setRecord (state, record) {
    state.record = record
  },
  setField (state, field) {
    state.record = {...state.record, ...field}
  },
  setSaveError (state, message) {
    state.onSaveError = message
  }
}

export const extractFromRecord = (record, keys) => {
  let ret = {};
  keys.forEach(k => {
    ret[k] = record ? record[k] : null
  })
  return ret
}

export const actions = {
  update (record) {
    return false
  },
  fetchOne ({commit, state}, id) {
    HTTP().get(state.baseEndpoint + '/' + id)
      .then(res => {
        commit('setRecord', extractFromRecord(res, state.recordFields))
        commit('layout/unblock', null, {root: true})
      })
      .catch(error => {
        commit('setRecord', null)
        commit('layout/unblock', null, {root: true})
        Helper.handleErrorResponse(error)
      })
  },
  saveOne ({commit, dispatch, state}, record) {
    HTTP().post(state.baseEndpoint + '/' + (record.id || '0'), record)
      .then(res => {
        dispatch('growl/success', 'Record saved', {root: true})
        router.push(state.baseRoute)
      })
      .catch(error => {
        Helper.handleErrorResponse(error)
      })
  }
}


export default (baseRoute, baseEndpoint, recordFields) => {
  const state = {
    ...createState(),
    baseRoute,
    baseEndpoint,
    recordFields
  }

  return {
    namespaced: true,
    state,
    mutations,
    actions
  }
}
