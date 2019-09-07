<?php

namespace Rocky\MailgunMailer\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Rocky\MailgunMailer\Models\MailgunMail;

class MailgunOutboundMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var MailgunMail
     */
    private $mail;

    /**
     * Create a new message instance.
     *
     * @param  MailgunMail  $mail
     */
    public function __construct(MailgunMail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from($this->mail->sender_email, $this->mail->sender_name)
            ->replyTo($this->mail->sender_email, $this->mail->sender_name)
            ->subject($this->mail->subject)
            ->with(['content' => $this->mail->body])
            ->view('mailgun-mailer::mail.blank');
    }
}
