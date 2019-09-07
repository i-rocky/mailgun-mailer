import Inbox from '../components/pages/mails/inbox/Inbox';
import Sent from '../components/pages/mails/Sent/Sent';
import Trash from '../components/pages/mails/trash/Trash';
import Templates from '../components/pages/templates/Templates';
import Composer from '../components/pages/compose/Composer';

export default [
  {
    name: 'dashboard',
    path: '/',
    component: Inbox,
  },
  {
    name: 'compose',
    path: '/compose',
    component: Composer,
  },
  {
    name: 'inbox',
    path: '/inbox',
    component: Inbox,
  },
  {
    name: 'sent',
    path: '/sent',
    component: Sent,
  },
  {
    name: 'trash',
    path: '/trash',
    component: Trash,
  },
  {
    name: 'templates',
    path: '/templates',
    component: Templates,
  },
];
