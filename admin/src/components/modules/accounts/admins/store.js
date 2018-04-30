import createStore from '@/main/crud'

export default createStore('/account/admins', 'admins', ['id', 'name', 'email', 'password', 'confirmPassword'])
