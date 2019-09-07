<?php

namespace Rocky\MailgunMailer\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Rocky\MailgunMailer\Models\MailgunMail;

class NewInboundMail
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var MailgunMail
     */
    public $mail;

    /**
     * Create a new event instance.
     *
     * @param  MailgunMail  $mail
     */
    public function __construct(MailgunMail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
