import moment from 'moment';
import MailMessage from '../models/MailMessage';

export default {
  mapMailMessagesToClient(messages) {
    return messages.map(message => this.mapMailMessageToClient(message));
  },
  mapMailMessageToClient(mailMessageInfo) {
    return new MailMessage(
      mailMessageInfo.id,
      mailMessageInfo.sender_name,
      mailMessageInfo.sender_email,
      mailMessageInfo.recipient_name,
      mailMessageInfo.recipient_email,
      mailMessageInfo.subject,
      mailMessageInfo.body,
      mailMessageInfo.direction,
      mailMessageInfo.read_at ? moment(mailMessageInfo.read_at) : null,
      mailMessageInfo.created_at ? moment(mailMessageInfo.created_at) : null,
    );
  },
  mapMailMessageToServer(mailMessage) {
    return {
      sender_name: mailMessage.sender_name,
      sender_email: `${mailMessage.sender_email}@clearequityrelease.co.uk`,
      recipient_name: mailMessage.recipient_name,
      recipient_email: mailMessage.recipient_email,
      subject: mailMessage.subject,
      body: mailMessage.body,
    };
  },
};