<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function ($browser){
            $browser->visit('/login')
                ->type('email', 'root@admin.com')
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home');
        });
    }
}
