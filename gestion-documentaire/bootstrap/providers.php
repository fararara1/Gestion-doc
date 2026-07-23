<?php

use App\Providers\AppServiceProvider;
use App\Providers\AuthServiceProvider;
use Illuminate\Mail\MailServiceProvider;

return [
    AppServiceProvider::class,
    AuthServiceProvider::class,
    MailServiceProvider::class,
];
