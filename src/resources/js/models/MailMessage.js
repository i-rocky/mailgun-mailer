export default class MailMessage {
  id;
  sender_name;
  sender_email;
  recipient_name;
  recipient_email;
  subject;
  body;
  direction;
  read_at;

  text;

  constructor(id,
              sender_name, sender_email,
              recipient_name, recipient_email,
              subject, body,
              direction, read_at) {
    this.id = id || null;
    this.sender_name = sender_name || null;
    this.sender_email = sender_email || null;
    this.recipient_name = recipient_name || null;
    this.recipient_email = recipient_email || null;
    this.subject = subject || null;
    this.body = body || '';
    this.direction = direction || null;
    this.read_at = read_at || null;

    const div = document.createElement('div');
    div.innerHTML = this.body;

    this.text = div.innerText;
  }

  get read() {
    return this.read_at !== null;
  }

  get excerpt() {
    return `<strong>${this.subject}</strong> - ${this.text}`
  }
}
