<?php

namespace Rocky\MailgunMailer\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MailTemplate
 *
 * @package Rocky\MailgunMailer\Models
 *
 * @property int id
 * @property string title
 * @property string subject
 * @property string body
 */
class MailTemplate extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'subject',
        'body',
    ];

    public function getRouteKey()
    {
        return 'mail_template';
    }
}
