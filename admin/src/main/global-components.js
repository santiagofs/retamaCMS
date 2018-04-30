import Vue from 'vue'

import RelativeYou from '@/components/ui/relatives/you'
import RelativeEmpty from '@/components/ui/relatives/empty'
import Relative from '@/components/ui/relatives/relative'
import RelativeSet from '@/components/ui/relatives/set'

import AdminModule from '@/components/layout/module/module'
import AdminCrud from '@/components/layout/module/crud'
import AdminResults from '@/components/layout/module/results'


import Checkbox from '@/components/shared/checkbox'
import Uploader from '@/components/shared/uploader'
import Growl from '@/components/shared/growl/growl'

Vue.component('relative-you', RelativeYou)
Vue.component('relative-empty', RelativeEmpty)
Vue.component('relative', Relative)
Vue.component('relative-set', RelativeSet)

Vue.component('admin-module', AdminModule)
Vue.component('admin-crud', AdminCrud)
Vue.component('admin-results', AdminResults)

Vue.component('checkbox', Checkbox)
Vue.component('uploader', Uploader)
Vue.component('growl', Growl)
