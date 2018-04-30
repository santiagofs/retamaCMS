import listFilter from '@/components/layout/module/results/filter'

const capitalize = (s) => {
  return s && s.charAt(0).toUpperCase() + s.slice(1)
}

const format = (store) => {
  return (record, field) => {
    return {
      template: '<router-link tag="a" :to="to">{{content}}</router-link>',
      data () { return {to: `/${store}/` + record.id, content: record[field.name]} }
    }
  }
}

const getFormatFunction = (field, linkField, index, store) => {
  if (field.format) return field.format
  if (linkField && field.name === linkField) return format(store)
  if (!linkField && index === 0) return format(store)
  return null
}

const buildQuery = (query, fields) => {
  if (query) return query
  const ret = {}
  fields.forEach(f => {
    ret[f.name] = null
  })
  return ret
}
const editable = (store) => {
  return (record) => { return `/${store}/` + record.id }
}

export const createData = (fields, store, options) => {
  const linkField = (options && options.linkField)

  const configFields = fields.map((e, i, a) => {
    const ret = {}
    if (typeof e === 'string') {
      ret.name = e
      ret.label = capitalize(e)
    } else {
      ret.name = e.name
      ret.label = e.label || capitalize(e.name)
    }
    ret.format = getFormatFunction(e, linkField, i, store)
    return ret
  })

  const config = {
    fields: configFields,
    editable: (options && options.editable !== undefined) ? options.editable : editable(store),
    selectable: (options && options.selectable !== undefined) ? options.selectable : true
  }

  const query = buildQuery((options && options.query), configFields)

  return {config, query}
}

export const createActivated = (store) => {
  return function () { this.$store.dispatch(store + '/fetchAll') }
}

export const createOnFilter = (store) => {
  return function () { this.$store.dispatch(store + '/filter', this.query) }
}

export const createListComponent = (fields, store, options) => {
  return {
    name: 'List',
    components: {'list-filter': listFilter},
    data () {
      return {
        ...createData(fields, store, options)
      }
    },
    methods: {
      onFilter: createOnFilter(store)
    },
    activated: createActivated(store)
  }
}

export default (fields, store, options) => {
  return {
    data: createData(fields, store, options),
    activated: () => createActivated(store),
    onFilter: () => createOnFilter(store)
  }
}
