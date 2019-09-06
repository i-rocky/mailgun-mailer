<?php

namespace Rocky\MailgunMailer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class MailgunMail
 *
 * @package Rocky\MailgunMailer\Models
 *
 * @property int id
 * @property int mailgun_mail_id
 * @property string filename
 * @property string path
 * @property MailgunMail mail
 */
class MailAttachment extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'mailgun_mail_id',
        'filename',
        'path',
    ];

    /**
     * @return BelongsTo
     */
    public function mail()
    {
        return $this->belongsTo(MailgunMail::class);
    }
}
