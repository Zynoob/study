import Vue from 'vue'
import Router from 'vue-router'
import Clock from './views/Clock.vue'

Vue.use(Router)

export default new Router({
  mode :'hash',
  base:__dirname,
  routes: [
    {
      path: '/clock',
      name: 'clock',
      component: Clock,
    },
    {
      path: '/cssEmoji',
      name: 'cssEmoji',
      // route level code-splitting
      // this generates a separate chunk (about.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import(/* webpackChunkName: "cssEmoji" */ './views/CssEmoji.vue')
    },
    {
      path: '/planet',
      name: 'planet',
      // route level code-splitting
      // this generates a separate chunk (about.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import(/* webpackChunkName: "planet" */ './views/Planet.vue')
    }
  ]
})
