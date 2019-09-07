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
    public $timestamps = false;

    protected $fillable = [
        'mailgun_mail_id',
        'filename',
        'path',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (MailAttachment $attachment) {
            $file = storage_path($attachment->path);
            if (file_exists($file)) {
                unlink($file);
            }
        });
    }

    /**
     * @return BelongsTo
     */
    public function mail()
    {
        return $this->belongsTo(MailgunMail::class);
    }
}
