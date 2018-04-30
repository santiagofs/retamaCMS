import Vue from 'vue'
import Router from 'vue-router'
import { HTTP } from './http'

import Auth from '../components/layout/auth'
import Ui from '../components/ui/ui'

import store from './store'
import dashboard from '../components/modules/dashboard/routes'
import content from '@/components/modules/content/routes'
import translations from '../components/modules/translations/routes'
import {userPublic, userProtected} from '../components/modules/accounts/routes'

Vue.use(Router)

const modulesRoutes = [
  ...dashboard,
  ...content,
  ...translations,
  ...userProtected
]

var router = new Router({
  routes: [
    {
      path: '/',
      component: Auth,
      children: modulesRoutes
    },
    {name: 'UI', path: '/ui', component: Ui},
    ...userPublic
  ]
})

var unauthenticatedPages = ['SignIn', 'UI']

router.beforeEach((to, from, next) => {
  if (unauthenticatedPages.indexOf(to.name) !== -1) return next()

  // page needs authentication
  // check we have a user
  store.dispatch('user/restoreUser')
  if (!store.state.user.logged) return next({ path: '/sign-in' })

  // check the session is still valid
  HTTP().get('check-token')
    .then(res => {
      // restart the token autorefresh in case user reloads the page
      store.dispatch('user/autoRefreshToken')
      if (to.fullPath === '/') {
        return next({ path: '/dashboard' })
      }
      next()
    })
    .catch(err => {
      console.log(err.response.data)
      store.commit('user/unsetUser')
      localStorage.removeItem('token');
      next({ path: '/sign-in' })
    })
})


export default router
