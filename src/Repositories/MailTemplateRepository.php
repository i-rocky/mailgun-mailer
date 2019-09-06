<?php

namespace Rocky\MailgunMailer\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Rocky\MailgunMailer\Models\MailTemplate;

class MailTemplateRepository
{
    /**
     * Search for mails
     *
     * @param  Request  $request
     *
     * @return LengthAwarePaginator
     */
    public function search(Request $request)
    {
        return MailTemplate::orderBy('title')->get();
    }

    /**
     * Store a new mail
     *
     * @param  Request  $request
     *
     * @return MailTemplate
     */
    public function store(Request $request)
    {
        $mail = new MailTemplate();
        $mail->fill($request->only($mail->getFillable()));
        $mail->save();

        return $mail;
    }

    /**
     * @param  MailTemplate  $template
     * @param  Request  $request
     *
     * @return MailTemplate
     */
    public function update(MailTemplate $template, Request $request)
    {
        $template->fill($request->only($template->getFillable()));
        if ($template->isDirty()) {
            $template->save();
        }

        return $template;
    }
}
