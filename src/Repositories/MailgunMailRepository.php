<?php

namespace Rocky\MailgunMailer\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Rocky\MailgunMailer\Models\MailgunMail;

class MailgunMailRepository
{
    /**
     * Store a new mail
     *
     * @param  Request  $request
     *
     * @return MailgunMail
     */
    public function store(Request $request)
    {
        $mail = new MailgunMail();
        $mail->fill($request->only($mail->getFillable()));
        $mail->direction = 'outbound';
        $mail->save();

        return $mail;
    }

    /**
     * Search for mails
     *
     * @param  Request  $request
     *
     * @return LengthAwarePaginator
     */
    public function search(Request $request)
    {
        /** @var Builder $query */
        $query = MailgunMail::orderBy('created_at');

        if ($request->has('email')) {
            $email = $request->get('email').'%';
            $query->where(function (Builder $query) use ($email) {
                $query->where('sender_email', 'LIKE', $email)
                      ->orWhere('recipient_email', 'LIKE', $email);
            });
        }

        if ($request->has('name')) {
            $name = $request->get('name').'%';
            $query->where(function (Builder $query) use ($name) {
                $query->where('sender_name', 'LIKE', $name)
                      ->orWhere('recipient_name', 'LIKE', $name);
            });
        }

        return $query->paginate($request->get('per-page', 10));
    }
}
