<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminTest extends DuskTestCase
{
    // php artisan serve --env=dusk.local

    /** @test */
    public function admin_can_create_company()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@gmail.com')
                    ->type('password', 'admini')
                    ->press('Login')
                    ->visit('/companies/create')
                    ->type('name', 'Dusk Test')
                    ->type('description', 'Test')
                    ->press('Submit')
                    ->assertPathIs('/companies')
                    ->assertSee('Company added successfully');
        });
    }

    /** @test */
    public function admin_can_edit_company()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/companies/36/edit')
                    ->type('name', 'Edit')
                    ->type('description', 'Edit')
                    ->press('Submit')
                    ->assertPathIs('/companies/36')
                    ->assertSee('Company updated successfully');
        });
    }

    /** @test */
    public function admin_can_create_project()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects/create')
                    ->type('name', 'Project Dusk Test')
                    ->select('company_id', 36)
                    ->type('days', 10)
                    ->type('description', 'Test')
                    ->press('Submit')
                    ->assertPathIs('/projects')
                    ->assertSee('Project added successfully');
        });
    }

    /** @test */
    public function admin_can_edit_project()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects/34/edit')
                    ->type('name', 'Second Edit')
                    ->type('days', 5)
                    ->type('description', 'Second Edit')
                    ->press('Submit')
                    ->assertPathIs('/projects/34')
                    ->assertSee('Project updated successfully');
        });
    }

    /** @test */
    public function admin_can_create_task()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/create')
                    ->type('name', 'Dusk Task')
                    ->select('project_id', 34)
                    ->type('days', 10)
                    ->press('Submit')
                    ->assertPathIs('/tasks')
                    ->assertSee('Task added successfully');
        });
    }

    /** @test */
    public function admin_can_edit_task()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/25/edit')
                    ->type('name', 'Edit')
                    ->type('days', 5)
                    ->press('Submit')
                    ->assertPathIs('/tasks/25')
                    ->assertSee('Task updated successfully');
        });
    }

    /** @test */
    public function admin_can_see_users()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/users')
                    ->assertSee('Users Table');
        });
    }

    /** @test */
    public function admin_can_edit_users()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/users/5/edit')
                    ->type('name', 'DuskUser')
                    ->type('email', 'duskuser@gmail.com')
                    ->radio('role', 'user')
                    ->check('permissions[create_task]')
                    ->press('Submit')
                    ->assertPathIs('/users')
                    ->assertSee('User updated successfully');
        });
    }

    /** @test */
    public function admin_can_add_comment_to_company()
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
    public function admin_can_add_comment_to_project()
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
    public function admin_can_add_comment_to_task()
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
    public function admin_can_add_member_to_project()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects/10')
                    ->assertSee('Add a member')
                    ->type('email', 'moderator@gmail.com')
                    ->press('Add!')
                    ->assertPathIs('/projects/10')
                    ->assertSee('moderator@gmail.com was added to the project successfully');
        });
    }

    /** @test */
    public function admin_cannot_add_member_with_invalid_email_to_project()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects/10')
                    ->assertSee('Add a member')
                    ->type('email', 'user123@gmail.com')
                    ->press('Add!')
                    ->assertPathIs('/projects/10')
                    ->assertSee('User does not exists');
        });
    }

    /** @test */
    public function admin_can_add_member_to_task()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/2')
                    ->assertSee('Add a member')
                    ->type('email', 'moderator@gmail.com')
                    ->press('Add!')
                    ->assertPathIs('/tasks/2')
                    ->assertSee('moderator@gmail.com was added to the task successfully');
        });
    }

    /** @test */
    public function admin_cannot_add_member_with_invalid_email_to_task()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/2')
                    ->assertSee('Add a member')
                    ->type('email', 'user123@gmail.com')
                    ->press('Add!')
                    ->assertPathIs('/tasks/2')
                    ->assertSee('User does not exists');
        });
    }
}
