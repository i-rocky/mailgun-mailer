<?php

namespace Rocky\MailgunMailer\Routing;

use Illuminate\Contracts\Routing\Registrar;

class RouteRegistrar
{
    /**
     * @var Registrar
     */
    private $router;

    /**
     * RouteRegistrar constructor.
     *
     * @param  Registrar  $router
     */
    public function __construct(Registrar $router)
    {
        $this->router = $router;
    }

    /**
     * register all routes
     */
    public function all()
    {
        $this->router->group(['middleware' => ['web']], function (Registrar $router) {
            $this->registerWebRoutes($router);
        });

        $this->router->group(['middleware' => ['api']], function (Registrar $router) {
            $this->registerApiRoutes($router);

            if (config('mailgun-mailer.enable_webhook')) {
                $this->registerIncomingWebhook($router);
            }
        });
    }

    /**
     * @param  Registrar  $router
     */
    private function registerApiRoutes(Registrar $router)
    {
        $router->group([
            'prefix'     => 'api/mailgun',
            'namespace'  => 'Api',
            'middleware' => $this->getMiddleware(['auth:api'])
        ], function (Registrar $router) {
            /**
             * Mails
             */
            $router->group(['prefix' => 'mails'], function (Registrar $router) {
                $router->get('/', 'MailController@index')->name('api.mailgun.mailer.mails');
                $router->post('/', 'MailController@send')->name('api.mailgun.mailer.mails.send');
                $router->get('/{mailgun_mail}', 'MailController@view')->name('api.mailgun.mailer.view');
                $router->delete('/{mailgun_mail}', 'MailController@delete')->name('api.mailgun.mailer.delete');
            });

            /**
             * Templates
             */
            $this->router->group(['prefix' => 'templates'], function (Registrar $router) {
                $router->get('/', 'TemplateController@index')->name('api.mailgun.mailer.templates');
                $router->post('/', 'TemplateController@store')->name('api.mailgun.mailer.templates.store');
                $router->get('/{mail_template}', 'TemplateController@view')
                       ->name('api.mailgun.mailer.templates.view');
                $router->put('/{mail_template}', 'TemplateController@update')
                       ->name('api.mailgun.mailer.templates.update');
                $router->delete('/{mail_template}', 'TemplateController@delete')
                       ->name('api.mailgun.mailer.templates.delete');
            });
        });
    }

    /**
     * @param  Registrar  $router
     */
    private function registerIncomingWebhook(Registrar $router)
    {
        $router->post('api/mailgun/webhook/{secret}', 'Api\WebhookController@processIncomingMail')
               ->middleware('verify-mailgun-secret')
               ->name('api.mailgun.mailer.webhook');
    }

    /**
     * @param  Registrar  $router
     */
    private function registerWebRoutes(Registrar $router)
    {
        $router->get('mailgun', 'MailgunController@index')
               ->middleware($this->getMiddleware('auth'))
               ->name('mailgun.mailer');

        $router->get('{mailgun}', 'MailgunController@index')
               ->where('mailgun', 'mailgun.+')
               ->middleware($this->getMiddleware('auth'));

    }

    /**
     * @param $middleware
     *
     * @return array
     */
    private function getMiddleware($middleware)
    {
        $extra_middleware = config('mailgun-mailer.middleware');

        if ($extra_middleware) {
            if (is_array($middleware)) {
                $middleware = array_merge($middleware, $extra_middleware);
            } else {
                $middleware = array_merge([$middleware], $extra_middleware);
            }
        }

        return $middleware;
    }
}
