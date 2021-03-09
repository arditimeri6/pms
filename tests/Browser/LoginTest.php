<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{

    /** @test */
    public function a_user_cannot_login_with_invalid_credentials()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Login')
                    ->type('email', 'admin1@gmail.com')
                    ->type('password', 'admini')
                    ->press('Login')
                    ->assertSee('These credentials do not match our records');
        });
    }
    /** @test */
    public function a_user_can_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->assertSee('Register')
                    ->type('name', 'admin')
                    ->type('email', 'admin@gmail.com')
                    ->type('password', 'admini')
                    ->type('password_confirmation', 'admini')
                    ->press('Register')
                    ->assertPathIs('/')
                    ->assertSee('Dashboard');
        });
    }

    /** @test */
    public function a_user_can_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Login')
                    ->type('email', 'admin@gmail.com')
                    ->type('password', 'admini')
                    ->press('Login')
                    ->assertPathIs('/')
                    ->assertSee('Dashboard');
        });
    }
}
