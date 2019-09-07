<?php

namespace Rocky\MailgunMailer\Http\Controllers\Api;

use App\Events\NewInboundMail;
use Illuminate\Http\Request;
use Rocky\MailgunMailer\Models\MailgunMail;

class WebhookController
{
    /**
     * Accept incoming mail
     *
     * @param  Request  $request
     */
    public function processIncomingMail(Request $request)
    {
        $from = $request->get('From');
        preg_match('#^(?P<name>.*?)\s\<(?P<email>.*?)\>$#', $from, $match);
        $from_name  = $match['name'];
        $from_email = $match['email'];

        $to = $request->get('To');
        preg_match('#^(?P<name>.*?)\s\<(?P<email>.*?)\>$#', $to, $match);
        $recipient_name  = $match['name'];
        $recipient_email = $match['email'];

        $subject = $request->get('Subject');
        $body    = $request->get('body-html');

        $mail = new MailgunMail();
        $mail->fill([
            'sender_name'     => $from_name,
            'sender_email'    => $from_email,
            'recipient_name'  => $recipient_name,
            'recipient_email' => $recipient_email,
            'subject'         => $subject,
            'body'            => $body,
        ]);
        $mail->direction = 'inbound';

        $mail->save();

        // TODO: accept attachments

        event(new NewInboundMail($mail));
    }
}
