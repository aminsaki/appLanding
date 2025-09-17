import { createRouter, createWebHistory } from 'vue-router'
import Users from '../views/users.vue'
import Home from "../commons/Layouts/home.vue"
import  Result from "../views/result.vue"


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      meta: {layout: Home},
      component: Users,
    },
        {
      path: '/result',
      name: 'result',
      meta: {layout: Result},
      component: Users,
    },


  ],
})

export default router
