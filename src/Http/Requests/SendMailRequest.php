<?php

namespace Rocky\MailgunMailer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $mailgun_domain = config('services.mailgun.domain');

        return [
            'sender_name'     => 'required|string',
            'sender_email'    => "required|email|regex:/(.+)@{$mailgun_domain}$/",
            'recipient_name'  => 'required|string',
            'recipient_email' => 'required|email',
            'subject'         => 'required|string',
            'body'            => 'required|string',
        ];
    }
}
