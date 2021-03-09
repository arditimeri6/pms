<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class ProjectTest extends TestCase
{
	use RefreshDatabase;

    public function setup()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
    }

    /** @test */
    public function user_visit_project_page()
    {
    	$user = factory(User::class)->create();
    	$this->actingAs($user);

    	$project = factory(Project::class)->create();
 		$response = $this->get('/projects');
 		$response->assertSee($project->name);
 		$response->assertStatus(200);
    }

    /** @test */
    public function user_visit_single_project_page()
    {
    	$user = factory(User::class)->create();
    	$this->actingAs($user);

    	$project = factory(Project::class)->create();
 		$response = $this->get('/projects/'.$project->id);
 		$response->assertStatus(200);
    }

    /** @test */
    public function user_visit_create_project_page()
    {
    	$user = factory(User::class)->create();
        $user->givePermissionTo('create_project');
    	$this->actingAs($user);

    	$project = factory(Project::class)->create();
 		$response = $this->get('/projects/create');
 		$response->assertStatus(200);
    }

    /** @test */
    public function user_visit_edit_project_page()
    {
    	$user = factory(User::class)->create();
        $user->givePermissionTo('edit_project');
    	$project = factory(Project::class)->create(['user_id' => $user->id]);
    	$this->actingAs($user);

 		$response = $this->get('/projects/'. $project->id . '/edit');
 		$response->assertStatus(200);
    }

    /** @test */ /* Asserts 200 istead of 403 */
    public function user_try_to_edit_another_users_project()
    {
        $user = factory(User::class)->create();
        $user->givePermissionTo('edit_project');
        $user2 = factory(User::class)->create();
        $user2->givePermissionTo('edit_project');
        $project = factory(Project::class)->create(['user_id' => $user->id]);
        $this->actingAs($user2);
        
        $response = $this->get('/projects/'. $project->id .'/edit');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_create_new_project()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->call('POST', '/projects',
            [
                'name' => 'test',
                'days' => 1,
                'description' => 'test',
            ]
        );
        $this->assertEquals(302, $response->getStatusCode());
        $response->assertRedirect('/projects');
    }

    /** @test */
    public function user_update_project()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->call('PUT', '/projects/'.$project->id,
            [
                'name' => 'test',
                'days' => 1,
                'description' => 'test',
            ]
        );
        $this->assertEquals(302, $response->getStatusCode());
        $response->assertRedirect('/projects/'.$project->id);
    }

    /** @test */
    public function user_add_member_to_project()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->call('POST', '/projects/adduser',
            [
                'email' => $user->email,
                'project_id' => $project->id,
            ]
        );

        $this->assertEquals(302, $response->getStatusCode());
        $response->assertRedirect('/projects/' .$project->id);
    }
}