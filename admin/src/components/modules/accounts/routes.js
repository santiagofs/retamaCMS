import SignIn from './sign-in'
import Profile from './profile'
import Account from './account'

import Users from './users/users'
import UsersList from './users/users-list'
import UsersEdit from './users/users-edit'

import Admins from './admins/admins'
import AdminsList from './admins/admins-list'
import AdminsEdit from './admins/admins-edit'

const userPublic = [
  {
    path: '/sign-in',
    name: 'SignIn',
    component: SignIn
  }
]

// const userProtected = [
//   {
//     path: '/profile',
//     name: 'Profile',
//     component: Profile
//   },
//   {
//     path: '/accounts',
//     name: 'Accounts',
//     component: Account,
//     redirect: '/accounts/users',
//     children: [
//       {path: '/users', component: Users, name: 'users', redirect: '/accounts/users/users-list', children: [
//         {path: '/', component: UsersList, name: 'users-list'},
//         {path: ':id', component: UsersEdit, name: 'users-edit'}
//       ]},
//       {path: '/admins', component: Admins, name: 'admins', redirect: '/accounts/admins/admins-list', children: [
//         {path: '/', component: AdminsList, name: 'admins-list'},
//         {path: ':id', component: AdminsEdit, name: 'admins-edit'}
//       ]}
//     ]
//   }
// ]

const userProtected = [
  {
    path: '/profile',
    name: 'Profile',
    component: Profile
  },
  {
    path: '/accounts',
    name: 'Account',
    component: Account,
    redirect: '/accounts/users',
    children: [{
      path: 'users',
      component: Users,
      children: [
        {path: '/', component: UsersList, name: 'users-list'},
        {path: ':id', component: UsersEdit, name: 'users-edit'}
      ]
    },
    {
      path: 'admins',
      component: Admins,
      children: [
        {path: '/', component: AdminsList, name: 'admins-list'},
        {path: ':id', component: AdminsEdit, name: 'admins-edit'}
      ]
    }]
  }
]

export {userPublic, userProtected}
