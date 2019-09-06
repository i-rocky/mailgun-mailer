<?php

namespace Rocky\MailgunMailer\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class MailTemplateResource
 *
 * @package Rocky\MailgunMailer\Http\Resources
 *
 * @property int id
 * @property string title
 * @property string subject
 * @property string body
 */
class MailTemplateResource extends JsonResource
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
            'id'      => $this->id,
            'title'   => $this->title,
            'subject' => $this->subject,
            'body'    => $this->body,
        ];
    }
}
