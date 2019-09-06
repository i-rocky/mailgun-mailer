<?php

namespace Rocky\MailgunMailer\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallMailgunMailer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailgun:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mailgun mailer for laravel';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Artisan::call('vendor:publish', [
            '--tag' => 'mailgun-mailer-config'
        ]);
        $this->info(Artisan::output());

        Artisan::call('vendor:publish', [
            '--tag'   => 'mailgun-mailer-assets',
            '--force' => true,
        ]);
        $this->info(Artisan::output());
    }
}
