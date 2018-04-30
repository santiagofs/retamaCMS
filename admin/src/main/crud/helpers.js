import * as Alerts from '@/main/alerts'

function parseLaravelErrors (errors) {
  return Object.keys(errors).map(key => {
    return errors[key][0]
  })
}

export const parseErrorResponse = (err, onSave) => {
  if (!err.response) return 'Network error'
  if (!err.response.data) return err.response
  if (err.response.status === 400) return parseLaravelErrors(err.response.data).join('\n')
  if (err.response.data.error) return err.response.data.error
  if (err.response.data.message) return err.response.data.message
  return err.response.data
}

export const handleErrorResponse = (err) => {
  return Alerts.makeAlert({
    title: 'Errors', body: parseErrorResponse(err), cssClass: 'danger'
  })
}

export const anyDirty = ($v) => {
  return Object.keys($v.$params).map(e => {
    return $v[e].$dirty
  }).indexOf(true) !== -1
}

export const mapRecord = (store, fields) => {
  let ret = {}
  fields.forEach(field => {
    let key, transform
    if (typeof field === 'string') {
      key = field
      transform = null
    } else {
      key = Object.keys(field)[0]
      transform = field[key]
    }
    ret[key] = {
      get () {
        const state = this.$store.state[store]
        let value = state.record ? (transform ? transform(state.record) : state.record[key]) : null
        return value
      },
      set (value) {
        let field = {};
        field[key] = value
        this.$store.commit(store + '/setField', field)
      }
    }
  })
  return ret
}

