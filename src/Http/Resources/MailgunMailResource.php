<?php

namespace Rocky\MailgunMailer\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Rocky\MailgunMailer\Models\MailAttachment;

/**
 * Class MailgunMailResource
 *
 * @package Rocky\MailgunMailer\Http\Resources
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
class MailgunMailResource extends JsonResource
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
            'sender_name'     => $this->sender_name,
            'sender_email'    => $this->sender_email,
            'recipient_name'  => $this->recipient_name,
            'recipient_email' => $this->recipient_email,
            'subject'         => $this->subject,
            'body'            => $this->body,
            'direction'       => $this->direction,
            'created_at'      => $this->created_at->toIso8601String(),
            'read_at'         => $this->read_at ? $this->read_at->toIso8601String() : null,
            'attachments'     => $this
                ->whenLoaded('attachments', MailAttachmentResource::collection($this->attachments)),
        ];
    }
}
