<?php

namespace Rocky\MailgunMailer\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class MailgunController
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('mailgun-mailer::index');
    }
}
