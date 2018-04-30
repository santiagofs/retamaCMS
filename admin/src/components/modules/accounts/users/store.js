import createStore from '@/main/crud'

export default createStore('/account/users', 'users', ['id', 'name', 'email', 'password', 'confirmPassword'])
