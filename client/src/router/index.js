import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/Login'
import Register from '@/components/Registration'
import Home from '@/components/Home'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/user/register',
      name: 'Registration',
      component: Register
    },
    {
      path: '/user/login',
      name: 'Login',
      component: Login
    }
  ]
})
