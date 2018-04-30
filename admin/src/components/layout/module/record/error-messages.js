function formatDate (date) {
  var dd = date.getDate()
  var mm = date.getMonth() + 1

  var yyyy = date.getFullYear()
  if (dd < 10) {
    dd = '0' + dd
  }
  if (mm < 10) {
    mm = '0' + mm;
  }
  return mm + '/' + dd + '/' + yyyy;
}

export default ($vfield) => {
  if (!$vfield.$error) return ''

  const errors = Object.keys($vfield.$params).filter(k => {
    return $vfield[k] === false;
  })
  const params = $vfield.$params[errors[0]]
  let min, max

  switch (params.type) {
    case 'required':
    case 'requiredIf':
      return 'This field is required'
    case 'minLength':
      return `This field should be at least ${params.minLength.min} characters long`
    case 'between':
      min = params.between.min instanceof Date ? formatDate(params.between.min) : params.between.min
      max = params.between.max instanceof Date ? formatDate(params.between.max) : params.between.max
      return `This field should be between ${min} and ${max}`
    case 'sameAs':
      return `This field should be the same than '${params.eq}'`
    case 'isHex':
      return `This is not a valid color`
    default:
      return 'no error message for ' + params.type
  }
}
