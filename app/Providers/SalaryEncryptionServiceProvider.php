<?php

namespace App\Providers;

use RuntimeException;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use App\Encrypterdecrypter;

class SalaryEncryptionServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('SalaryEnrypterDecrypter', function ($app) {
            $config = $app->make('config')->get('app');

            // If the key starts with "base64:", we will need to decode the key before handing
            // it off to the encrypter. Keys may be base-64 encoded for presentation and we
            // want to make sure to convert them back to the raw bytes before encrypting.
            if (Str::startsWith($key = $this->key($config), 'base64:')) {
                $key = base64_decode(substr($key, 7));
            }

            return new \App\Encrypterdecrypter\SalaryEnrypterDecrypter($key, $config['cipher']);
        });
    }

    /**
     * Extract the encryption key from the given configuration.
     *
     * @param  array  $config
     * @return string
     */
    protected function key(array $config)
    {
        return tap($config['SalaryKey'], function ($key) {
            if (empty($key)) {
                throw new RuntimeException(
                    'No application encryption key has been specified.'
                );
            }
        });
    }
}
