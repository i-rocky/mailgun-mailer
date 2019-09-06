import Vue from 'vue';
import VueRouter from 'vue-router';
import router from './router';
import ErrorHandler from './mixins/ErrorHandler';

Vue.use(VueRouter);

Vue.mixin(ErrorHandler);

(new Vue({
  router,
}).$mount('#app'));
