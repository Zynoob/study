import Vue from 'vue'
import Router from 'vue-router'
import Index from './login'
import Student from './student'
import Teacher from './teacher'
import Admin from './admin'

import {
  LoadingBar
} from 'iview';

Vue.use(Router);

let routes = [
  ...Index,
  ...Student,
  ...Teacher,
  ...Admin,
  {
    path: '*',
    redirect: '/log/in'
  }
]

const router = new Router({
  routes
});

router.beforeEach((to, from, next) => {
  if (to.name != "login" && to.name != "register") {
    let isLogin = sessionStorage.getItem("isLogin");
    if (isLogin == 'true') {
      LoadingBar.start();
      next();
    } else {
      next('/login');
    }
  } else {
    sessionStorage.removeItem("isLogin");
    sessionStorage.removeItem("user_name");
    LoadingBar.start();
    next();
  }
});

router.afterEach(() => {
  LoadingBar.finish();
});
export default router;