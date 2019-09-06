import Vue from 'vue';
import VueRouter from 'vue-router';
import router from './router';
import ErrorHandler from './mixins/ErrorHandler';
import Layout from './components/Layout';

require('./bootstrap');

Vue.use(VueRouter);

Vue.mixin(ErrorHandler);

(new Vue({
  render: h => h(Layout),
  router,
}).$mount('#app'));
