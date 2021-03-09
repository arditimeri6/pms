<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ManagerTest extends DuskTestCase
{
    /** @test */
    public function manager_cannot_create_company()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'manager@gmail.com')
                    ->type('password', 'manager')
                    ->press('Login')
                    ->visit('/companies/create')
                    ->assertSee('403');
        });
    }

    /** @test */
    public function manager_cannot_edit_company()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/companies/25/edit')
                    ->assertSee('403');
        });
    }

    /** @test */
    public function manager_can_create_project()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects/create')
                    ->type('name', 'Project Dusk')
                    ->select('company_id', 36)
                    ->type('days', 10)
                    ->type('description', 'Test')
                    ->press('Submit')
                    ->assertPathIs('/projects')
                    ->assertSee('Project added successfully');
        });
    }

    /** @test */
    public function manager_can_edit_project()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects/2/edit')
                    ->type('name', 'Project dusk edit')
                    ->type('days', 5)
                    ->type('description', 'Edit')
                    ->press('Submit')
                    ->assertPathIs('/projects/2')
                    ->assertSee('Project updated successfully');
        });
    }

    /** @test */
    public function manger_cannot_edit_another_user_project()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects/10/edit')
                    ->assertSee('403');
        });
    }

    /** @test */
    public function manager_can_create_task()
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
    public function manager_can_edit_task()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/26/edit')
                    ->type('name', 'Edit')
                    ->type('days', 5)
                    ->press('Submit')
                    ->assertPathIs('/tasks/26')
                    ->assertSee('Task updated successfully');
        });
    }

    /** @test */
    public function manager_cannot_edit_another_users_task()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/10/edit')
                    ->assertSee('403');
        });
    }

    /** @test */
    public function manager_can_add_comment_to_company()
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
    public function manager_can_add_comment_to_project()
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
    public function manager_can_add_comment_to_task()
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
    public function manager_can_add_member_to_project()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects/2')
                    ->assertSee('Add a member')
                    ->type('email', 'moderator@gmail.com')
                    ->press('Add!')
                    ->assertPathIs('/projects/2')
                    ->assertSee('moderator@gmail.com was added to the project successfully');
        });
    }

    /** @test */
    public function manager_cannot_add_member_with_invalid_email_to_project()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects/2')
                    ->assertSee('Add a member')
                    ->type('email', 'user123@gmail.com')
                    ->press('Add!')
                    ->assertPathIs('/projects/2')
                    ->assertSee('User does not exists');
        });
    }

    /** @test */
    public function manager_can_add_member_to_task()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/12')
                    ->assertSee('Add a member')
                    ->type('email', 'moderator@gmail.com')
                    ->press('Add!')
                    ->assertPathIs('/tasks/12')
                    ->assertSee('moderator@gmail.com was added to the task successfully');
        });
    }

    /** @test */
    public function manager_cannot_add_member_with_invalid_email_to_task()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/12')
                    ->assertSee('Add a member')
                    ->type('email', 'user123@gmail.com')
                    ->press('Add!')
                    ->assertPathIs('/tasks/12')
                    ->assertSee('User does not exists');
        });
    }
}