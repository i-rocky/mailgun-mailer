<?php

namespace Rocky\MailgunMailer\Http\Middleware;

use Closure;

class VerifyMailgunSecret
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $secret = $request->route('secret');
        if (config('mailgun-mailer.secret') !== $secret) {
            return abort(419);
        }

        return $next($request);
    }
}
