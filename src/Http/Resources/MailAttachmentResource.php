<?php

namespace Rocky\MailgunMailer\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Rocky\MailgunMailer\Models\MailgunMail;

/**
 * Class MailgunMailResource
 *
 * @package Rocky\MailgunMailer\Http\Resources
 *
 * @property int id
 * @property int mailgun_mail_id
 * @property string filename
 * @property string path
 * @property string url
 * @property MailgunMail mail
 */
class MailAttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'mailgun_mail_id' => $this->mailgun_mail_id,
            'name'            => $this->filename,
            'url'             => $this->url,
        ];
    }
}
