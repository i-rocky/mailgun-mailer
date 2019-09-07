import httpService from './services/httpService';
import MailMessageMapper from './mappers/MailMessageMapper';

export default {
  get(box) {
    return new Promise((resolve, reject) => {
      httpService
        .get(`mails`, {box})
        .then(response => resolve(MailMessageMapper.mapMailMessagesToClient(response.data)))
        .catch(error => reject(error));
    });
  },
  send(mailMessage) {
    return httpService.postJSON('mails', MailMessageMapper.mapMailMessageToServer(mailMessage));
  },
  view(id) {
    return new Promise((resolve, reject) => {
      httpService
        .get(`mails/${id}`)
        .then(response => resolve(MailMessageMapper.mapMailMessageToClient(response.data)))
        .catch(error => reject(error));
    });
  },
  delete(id) {
    return httpService.delete(`mails/${id}`);
  },
};
