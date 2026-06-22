<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('mail:test-contact', function () {
    Mail::raw('Day la email test tu Blue Wave Travel.', function ($message) {
        $message->to('haohuynh090805@gmail.com')
            ->subject('Blue Wave Travel - Test email');
    });

    $this->info('Da gui email test toi haohuynh090805@gmail.com.');
})->purpose('Send a test contact email');
