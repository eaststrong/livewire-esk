<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

$fFunction = function () {
  $quote = Inspiring::quote();
  $this->comment($quote);
};

$command = Artisan::command('inspire', $fFunction);
$command->purpose('Display an inspiring quote');
