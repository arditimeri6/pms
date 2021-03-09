<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends DuskTestCase
{
    /** @test */
    public function user_cannot_create_company()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'user@gmail.com')
                    ->type('password', '123456')
                    ->press('Login')
                    ->visit('/companies/create')
                    ->assertSee('403');
        });
    }

    /** @test */
    public function user_cannot_edit_company()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/companies/25/edit')
                    ->assertSee('403');
        });
    }

    /** @test */
    public function user_cannot_create_project()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects/create')
                    ->assertSee('403');
        });
    }

    /** @test */
    public function user_cannot_edit_project()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects/10/edit')
                    ->assertSee('403');
        });
    }

    /** @test */
    public function user_can_create_task()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/create')
                    ->type('name', 'Dusk Task')
                    ->select('project_id', 35)
                    ->type('days', 10)
                    ->press('Submit')
                    ->assertPathIs('/tasks')
                    ->assertSee('Task added successfully');
        });
    }

    /** @test */
    public function user_can_edit_task()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/27/edit')
                    ->type('name', 'Edit')
                    ->type('days', 5)
                    ->press('Submit')
                    ->assertPathIs('/tasks/27')
                    ->assertSee('Task updated successfully');
        });
    }

    /** @test */
    public function user_cannot_edit_another_users_task()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/2/edit')
                    ->assertSee('403');
        });
    }

    /** @test */
    public function user_can_add_comment_to_company()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/companies/23')
                    ->assertSee('Add a comment')
                    ->type('url', 'dusk.com')
                    ->type('body', 'Comment from testing with dusk')
                    ->press('Submit')
                    ->assertPathIs('/companies/23')
                    ->assertSee('Comment added successfully');
        });
    }

    /** @test */
    public function user_can_add_comment_to_project()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects/2')
                    ->assertSee('Add a comment')
                    ->type('url', 'dusk.com')
                    ->type('body', 'Comment from testing with dusk')
                    ->press('Submit')
                    ->assertPathIs('/projects/2')
                    ->assertSee('Comment added successfully');
        });
    }

    /** @test */
    public function user_can_add_comment_to_task()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/2')
                    ->assertSee('Add a comment')
                    ->type('url', 'dusk.com')
                    ->type('body', 'Comment from testing with dusk')
                    ->press('Submit')
                    ->assertPathIs('/tasks/2')
                    ->assertSee('Comment added successfully');
        });
    }

    /** @test */
    public function user_can_add_member_to_task()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/4')
                    ->assertSee('Add a member')
                    ->type('email', 'moderator@gmail.com')
                    ->press('Add!')
                    ->assertPathIs('/tasks/4')
                    ->assertSee('moderator@gmail.com was added to the task successfully');
        });
    }

    /** @test */
    public function user_cannot_add_member_with_invalid_email_to_task()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/4')
                    ->assertSee('Add a member')
                    ->type('email', 'user123@gmail.com')
                    ->press('Add!')
                    ->assertPathIs('/tasks/4')
                    ->assertSee('User does not exists');
        });
    }
}