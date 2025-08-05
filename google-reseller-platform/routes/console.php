<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule the billing command to run daily
Schedule::command('billing:process')->daily();

// Schedule sitemap generation to run daily
Schedule::command('sitemap:generate')->daily();
