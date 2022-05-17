<?php

use Illuminate\Support\Facades\Facade;

return [
  'aliases' => Facade::defaultAliases()->merge([])->toArray(),
  'asset_url' => env('ASSET_URL'),
  'cipher' => 'AES-256-CBC',
  'debug' => (bool) env('APP_DEBUG', true),
  'env' => env('APP_ENV', 'local'),
  'faker_locale' => 'en_US',
  'fallback_locale' => 'en',
  'key' => env('APP_KEY', 'base64:gzKrqKSyc2alkojkFLG0QR4pwRuqkmTS6sXLCpVjiJU='),
  'locale' => 'en',
  'maintenance' => ['driver' => 'cache'],
  'name' => env('APP_NAME', 'livewire-esk'),

  'providers' => [
    Illuminate\Auth\AuthServiceProvider::class,
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
    Illuminate\Bus\BusServiceProvider::class,
    Illuminate\Cache\CacheServiceProvider::class,
    Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
    Illuminate\Cookie\CookieServiceProvider::class,
    Illuminate\Database\DatabaseServiceProvider::class,
    Illuminate\Encryption\EncryptionServiceProvider::class,
    Illuminate\Filesystem\FilesystemServiceProvider::class,
    Illuminate\Foundation\Providers\FoundationServiceProvider::class,
    Illuminate\Hashing\HashServiceProvider::class,
    Illuminate\Mail\MailServiceProvider::class,
    Illuminate\Notifications\NotificationServiceProvider::class,
    Illuminate\Pagination\PaginationServiceProvider::class,
    Illuminate\Pipeline\PipelineServiceProvider::class,
    Illuminate\Queue\QueueServiceProvider::class,
    Illuminate\Redis\RedisServiceProvider::class,
    Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
    Illuminate\Session\SessionServiceProvider::class,
    Illuminate\Translation\TranslationServiceProvider::class,
    Illuminate\Validation\ValidationServiceProvider::class,
    Illuminate\View\ViewServiceProvider::class,

    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
    App\Providers\JetstreamServiceProvider::class,
  ],

  'timezone' => 'UTC',
  'url' => env('APP_URL', 'http://localhost'),
];
