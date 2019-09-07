import VueRouter from 'vue-router';
import routes from './Routes';

const router = new VueRouter({
  mode: 'history',
  base: 'mailgun',
  routes,
  scrollBehavior() {
    return {x: 0, y: 0};
  },
});

router.beforeEach((to, from, next) => {
  //
  next();
});

router.afterEach(() => {
  // Vue.nextTick(markActiveLink);
});

export default router;
