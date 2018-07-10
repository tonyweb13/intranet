<?php

namespace Tests;

use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        // static::startChromeDriver();
    }

    public static function tearDownDuskClass()
    {
        parent::tearDownDuskClass();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        /************************************************************************************
        //In you root file outside laradock run the following in CMD in order to use SELENIUM
        npm install selenium-standalone@latest -g
        selenium-standalone install
        selenium-standalone start
        ************************************************************************************/

        $options = (new ChromeOptions())->addArguments(['--start-maximized']);

        return RemoteWebDriver::create(
            env('APP_SELENIUM_URL'), DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }
}
