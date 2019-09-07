import axios from 'axios';
import ResponseMapperService from '../mappers/ResponseMapper';

axios.defaults.baseURL = '/api/mailgun';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');

axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

axios.interceptors.response.use(response => response, error => {
  if (error.response.status === 401) {
    window.location = '/login';
  }
  return Promise.reject(error);
});

export default {
  get(route, params = {}, config = {}) {
    const promise = axios.get(route, makeGetRequest(params, config));
    return withMappedPromise(promise);
  },
  post(route, data = {}) {
    const promise = axios.post(route, makeFormRequest(data));
    return withMappedPromise(promise);
  },
  postJSON(route, data = {}) {
    const promise = axios.post(route, data);
    return withMappedPromise(promise);
  },
  put(route, data = {}) {
    const promise = axios.put(route, makeFormRequest(data));
    return withMappedPromise(promise);
  },
  putJSON(route, data = {}) {
    const promise = axios.put(route, data);
    return withMappedPromise(promise);
  },
  patch(route, data = {}) {
    const promise = axios.patch(route, makeFormRequest(data));
    return withMappedPromise(promise);
  },
  delete(route, data = {}) {
    const promise = axios.delete(route, {data});
    return withMappedPromise(promise);
  },
  cancellableTokenSource() {
    return axios.CancelToken.source();
  },
};

function withMappedPromise(promise) {
  return new Promise((resolve, reject) => {
    promise.then(response => resolve(
        ResponseMapperService.mapSuccessResponse(response)))
           .catch(error => reject(ResponseMapperService.mapErrorResponse(error)));
  });
}

function makeFormRequest(data) {
  const form = new FormData();
  Object.keys(data).forEach(key => {
    form.append(key, data[key]);
  });
  return form;
}

function makeGetRequest(params = {}, config = {}) {
  return {
    params: {
      ...params,
    },
    ...config,
  };
}
