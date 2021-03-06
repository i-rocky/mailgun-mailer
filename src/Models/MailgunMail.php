<?php

namespace Rocky\MailgunMailer\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rocky\MailgunMailer\Jobs\SendMail;

/**
 * Class MailgunMail
 *
 * @package Rocky\MailgunMailer\Models
 *
 * @property int id
 * @property string sender_name
 * @property string sender_email
 * @property string recipient_name
 * @property string recipient_email
 * @property string subject
 * @property string body
 * @property string direction
 * @property Carbon updated_at
 * @property Carbon created_at
 * @property Carbon read_at
 * @property MailAttachment[] attachments
 */
class MailgunMail extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'sender_name',
        'sender_email',
        'recipient_name',
        'recipient_email',
        'subject',
        'body',
        'direction',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function (MailgunMail $mail) {
            if ($mail->isOutbound()) {
                dispatch(new SendMail($mail));
            }
        });

        static::deleting(function(MailgunMail $mail) {
            if($mail->isForceDeleting()) {
                $mail->attachments->each->delete();
            }
        });
    }

    /**
     * @return bool
     */
    public function isInbound()
    {
        return $this->direction === 'inbound';
    }

    /**
     * @return bool
     */
    public function isOutbound()
    {
        return $this->direction === 'outbound';
    }

    /**
     * @return mixed|string
     */
    public function getRouteKey()
    {
        return 'mailgun_mail';
    }

    /**
     * @return HasMany
     */
    public function attachments()
    {
        return $this->hasMany(MailAttachment::class, 'mail_id');
    }
}
