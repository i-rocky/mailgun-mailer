<?php

namespace Rocky\MailgunMailer\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Rocky\MailgunMailer\Events\NewInboundMail;
use Rocky\MailgunMailer\Models\MailAttachment;
use Rocky\MailgunMailer\Models\MailgunMail;

class WebhookController
{
    /**
     * Accept incoming mail
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function processIncomingMail(Request $request)
    {
        $from_name = '';
        $from      = $request->get('From');
        preg_match('#^(?P<name>.*?)\s\<(?P<email>.*?)\>$#', $from, $match);
        if (isset($match['name'])) {
            $from_name  = $match['name'];
            $from_email = $match['email'];
        } else {
            $from_email = $from;
        }

        $recipient_name = '';
        $to             = $request->get('To');
        preg_match('#^(?P<name>.*?)\s\<(?P<email>.*?)\>$#', $to, $match);
        if (isset($match['name'])) {
            $recipient_name  = $match['name'];
            $recipient_email = $match['email'];
        } else {
            $recipient_email = $to;
        }

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

        foreach ($request->files as $key => $_) {
            /** @var UploadedFile $file */
            $file = $request->file($key);
            $file->storeAs('public/attachments', $file->hashName());

            $attachment = new MailAttachment();
            $attachment->mail()->associate($mail);

            $attachment->filename = $file->getClientOriginalName();
            $attachment->path     = $file->hashName('app/public/attachments');
            $attachment->save();
        }

        event(new NewInboundMail($mail));

        return response()->json(['message' => 'Mail Received']);
    }
}
