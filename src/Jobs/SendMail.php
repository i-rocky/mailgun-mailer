<?php

namespace Rocky\MailgunMailer\Jobs;

use App\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Rocky\MailgunMailer\Mail\MailgunOutboundMail;
use Rocky\MailgunMailer\Models\MailgunMail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var MailgunMail
     */
    private $mail;

    /**
     * Create a new job instance.
     *
     * @param  MailgunMail  $mail
     */
    public function __construct(MailgunMail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        $user        = new User();
        $user->name  = $this->mail->recipient_name;
        $user->email = $this->mail->recipient_email;

        Mail::to($user)->send(new MailgunOutboundMail($this->mail));
    }
}
