import axios from 'axios'

const baseURL = process.env.API_URL

const responseInterceptor = (res) => {
  return res.data
}

const HTTP = function () {
  const token = localStorage.getItem('token')
  const headers = token ? {Authorization: 'Bearer ' + token} : {}
  const http = axios.create({
    baseURL,
    headers
  })
  http.interceptors.response.use(responseInterceptor)
  return http
}

// const HTTP = axios.create({
//   baseURL
// })
// HTTP.interceptors.response.use(responseInterceptor)


//
// const AuthHTTP = axios.create({
//   baseURL,
//   headers: {
//     Authorization: 'Bearer ' + token
//   }
// })
// AuthHTTP.interceptors.response.use(responseInterceptor)

export { HTTP }
