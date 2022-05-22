<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

$fCommand = function () {
  $quote = Inspiring::quote();
  $this->comment($quote);
};

$command = Artisan::command('inspire', $fCommand);
$command->purpose('Display an inspiring quote');
