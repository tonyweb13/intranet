<?php

namespace App\Encrypterdecrypter;

class SalarEncyptFacade extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'SalaryEnrypterDecrypter';
    }
}