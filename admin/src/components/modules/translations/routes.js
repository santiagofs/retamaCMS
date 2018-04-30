import Translations from './translations'
import Dynamic from './dynamic/dynamic'
import DynamicList from './dynamic/dynamic-list'
import DynamicEdit from './dynamic/dynamic-edit'

export default [
  {
    path: '/translations',
    name: 'Translations',
    component: Translations,
    redirect: '/translations/dynamic',
    children: [{
      path: 'dynamic',
      component: Dynamic,
      children: [
        {path: '/', component: DynamicList, name: 'dynamic-list'},
        {path: ':id', component: DynamicEdit, name: 'dynamic-edit'}
      ]
    }]
  }
]
