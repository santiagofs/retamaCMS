import Content from './content'
import Pages from './pages/pages'
import PagesList from './pages/pages-list'
import PagesEdit from './pages/pages-edit'

export default [
  {
    path: '/content',
    name: 'Content',
    component: Content,
    redirect: '/content/pages',
    children: [{
      path: 'pages',
      component: Pages,
      children: [
        {path: '/', component: PagesList, name: 'pages-list'},
        {path: ':id', component: PagesEdit, name: 'pages-edit'}
      ]
    }, {
      path: 'news',
      component: Pages,
      children: [
        {path: '/', component: PagesList, name: 'news-list'},
        {path: ':id', component: PagesEdit, name: 'news-edit'}
      ]
    }, {
      path: 'widgets',
      component: Pages,
      children: [
        {path: '/', component: PagesList, name: 'widgets-list'},
        {path: ':id', component: PagesEdit, name: 'widgets-edit'}
      ]
    }, {
      path: 'productions',
      component: Pages,
      children: [
        {path: '/', component: PagesList, name: 'productions-list'},
        {path: ':id', component: PagesEdit, name: 'productions-edit'}
      ]
    }]
  }
]
