<?php

namespace Rocky\MailgunMailer\Providers;

use Illuminate\Support\ServiceProvider;
use Rocky\MailgunMailer\Console\Commands\InstallMailgunMailer;

class MailgunMailerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/mailgun-mailer.php' => config_path('mailgun-mailer.php')
            ], 'mailgun-mailer-config');

            $this->publishes([
                __DIR__.'/../public/' => public_path('vendor/mailgun-mailer/')
            ], 'mailgun-mailer-assets');

            $this->publishes([
                __DIR__.'/../public/fonts' => public_path('fonts/')
            ], 'mailgun-mailer-assets');

            $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

            $this->registerCommands();
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'mailgun-mailer');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/mailgun-mailer'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/mailgun-mailer.php', 'mailgun-mailer');
    }

    /**
     * Installer
     */
    private function registerCommands()
    {
        $this->commands([
            InstallMailgunMailer::class,
        ]);
    }
}
