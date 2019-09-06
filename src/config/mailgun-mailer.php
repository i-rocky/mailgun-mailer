<?php

return [
    'enable_webhook' => env('ENABLE_WEBHOOK', true),
    'secret'         => env('MAILGUN_MAILER_SECRET'),
    'middleware'     => [],
];
