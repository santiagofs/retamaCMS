import store from '@/main/store'

export let makeAlert = (config) => {
  const deferred = new Promise((resolve, reject) => {
    if (config.accept || config.promise) {
      config.accept = config.accept || {}
      config.accept.action = () => {
        resolve()
      }
    }
  })
  store.commit('layout/alert', config, {root: true})
  return deferred
}

export let deleteConfirm = () => {
  return makeAlert({
    title: 'Delete records', body: 'This action is not undoable.\n Are you sure you want to proceed?', cssClass: 'warning', captionPrimary: 'Delete', promise: true
  })
}

export let pendingErrors = () => {
  return makeAlert({
    title: 'Pending errors', body: 'The form has some errors that need your attention', cssClass: 'danger'
  })
}

export let confirmLeave = (confirmAction) => {
  return makeAlert({
    title: 'Pending changes', body: 'The form has unsaved changes.\nDo you want to leave anyway?', cssClass: 'warning', promise: true
  })
}

export let nothingSelected = () => {
  return makeAlert({
    title: 'Nothing selected', body: 'Please, select some records first', cssClass: 'warning'
  })
}

