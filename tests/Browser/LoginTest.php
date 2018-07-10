<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{

    public function testUserAccess()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('input[placeholder="Employee No"]', '20160135')
                    ->type('input[placeholder="●●●●●●●"]', 'pass1234')
                    ->press('Login')
                    ->pause(1000)
                    ->assertPathIs('/home');
        });
    }
}
