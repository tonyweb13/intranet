<?php
/**
 * Created by PhpStorm.
 * User: cestipular
 * Date: 6/20/2018
 * Time: 2:51 PM
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */
    'default' => env('LOG_CHANNEL', 'slack'),
    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "custom", "stack"
    |
    */
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
        ],
        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],
        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'days' => 7,
        ],
        'slack' => [
            'driver' => 'slack',
            'url' =>  env('LOG_SLACK_WEBHOOK_URL', 'https://hooks.slack.com/services/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') ,
            'username' => env('LOG_SLACK_USERNAME', 'LFS Dev Logs'),
            'name' => 'LFS Dev',
            'emoji' => ':boom:',
        ],
        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],
        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'debug',
        ],
    ],
];