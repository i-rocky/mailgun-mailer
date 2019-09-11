<?php

namespace Rocky\MailgunMailer;

use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;
use Rocky\MailgunMailer\Models\MailgunMail;
use Rocky\MailgunMailer\Routing\RouteRegistrar;

class MailgunMailer {

    /**
     * Register routes
     *
     * @param  null  $callback
     * @param  array  $options
     */
    public static function routes($callback = null, $options = [])
    {
        Route::model('mailgun_mail', MailgunMail::class);

        $callback = $callback ?: function (RouteRegistrar $router) {
            $router->all();
        };

        $defaultOptions = [
            'namespace' => '\Rocky\MailgunMailer\Http\Controllers',
        ];

        $options = array_merge($defaultOptions, $options);

        Route::group($options, function (Registrar $router) use ($callback) {
            $callback(new RouteRegistrar($router));
        });
    }
}