import Vue from 'vue';
import MailMessageAPI from '../MailMessageAPI';
import {email} from 'vee-validate/dist/rules.esm';

const storage = new Vue({
  data: {
    mails: [],
  },
  computed: {
    offset() {
      return Math.max.apply(Math, this.mails.map(function(o) { return o.id; })) || undefined;
    },
  },
});

let timeout;

const heartbeat = () => {
  if (timeout) {
    clearTimeout(timeout);
  }
  MailMessageAPI
    .get({offset: storage.offset})
    .then(mails => {
      storage.mails = mails;
    })
    .catch(error => {
      message.error(error.message);
    })
    .finally(() => {
      timeout = setTimeout(heartbeat, 10 * 60 * 1000);
    });
};

export default {
  install(Vue, $options) {
    heartbeat();
    Vue.mixin({
      computed: {
        inbox() {
          return this._mails.filter(mail => mail.direction === 'inbound');
        },
        sent() {
          return this._mails.filter(mail => mail.direction === 'outbound');
        },
        _mails() {
          return storage.mails.sort((a, b) => (a.id > b.id ? 1 : -1));
        },
      },
    });

    Vue.prototype.$storage = {
      reload() {
        heartbeat();
      },
      getStorage() {
        return storage;
      },
    };
  },
};
