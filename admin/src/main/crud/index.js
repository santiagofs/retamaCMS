import listStore from './list'
import itemStore from './item'


export default (baseRoute, baseEndpoint, recordFields) => {
  const list = listStore(baseRoute, baseEndpoint)
  const item = itemStore(baseRoute, baseEndpoint, recordFields)
  const store = {
    namespaced: true,
    state: {...list.state, ...item.state},
    mutations: {...list.mutations, ...item.mutations},
    actions: {...list.actions, ...item.actions},
    getters: {...list.getters}
  }

  return store
}
