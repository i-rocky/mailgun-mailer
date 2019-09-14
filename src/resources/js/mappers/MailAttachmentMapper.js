import MailAttachment from '../models/MailAttachment';

export default {
  mapMailAttachmentsToClient(attachments) {
    return attachments.map(message => this.mapMailAttachmentToClient(message));
  },
  mapMailAttachmentToClient(attachmentInfo) {
    return new MailAttachment(
      attachmentInfo.id,
      attachmentInfo.name,
      attachmentInfo.url,
    );
  },
  mapMailAttachmentsToServer(attachments) {
    return attachments.map(attachment => this.mapMailAttachmentToServer(attachment));
  },
  mapMailAttachmentToServer(attachment) {
    return {
      name: attachment.name,
      file: attachment.file,
    };
  },
};