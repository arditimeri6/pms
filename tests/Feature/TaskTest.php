<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Task;
use App\User;
use App\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class TaskTest extends TestCase
{
	use RefreshDatabase;
    
    public function setup()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
    }

    /** @test */
    public function user_visit_task_page()
    {
    	$user = factory(User::class)->create();
    	$this->actingAs($user);

    	$task = factory(Task::class)->create();
 		$response = $this->get('/tasks');
 		$response->assertSee($task->name);
 		$response->assertStatus(200);
    }

    /** @test */
    public function user_visit_single_task_page()
    {
    	$user = factory(User::class)->create();
    	$this->actingAs($user);

    	$task = factory(Task::class)->create();
 		$response = $this->get('/tasks/'.$task->id);
 		$response->assertStatus(200);
    }

    /** @test */
    public function user_visit_create_task_page()
    {
    	$user = factory(User::class)->create();
        $user->givePermissionTo('create_task');
    	$this->actingAs($user);

    	$task = factory(Task::class)->create();
 		$response = $this->get('/tasks/create');
 		$response->assertStatus(200);
    }

    /** @test */
    public function user_visit_edit_task_page()
    {
    	$user = factory(User::class)->create();
        $user->givePermissionTo('edit_task');
    	$task = factory(Task::class)->create(['user_id' => $user->id]);
    	$this->actingAs($user);

 		$response = $this->get('/tasks/'. $task->id . '/edit');
 		$response->assertStatus(200);
    }

    /** @test */ 
    public function user_try_to_edit_another_users_task()
    {
        $user = factory(User::class)->create();
        $user->givePermissionTo('edit_task');
        $user2 = factory(User::class)->create();
        $user2->givePermissionTo('edit_task');
        $task = factory(Task::class)->create(['user_id' => $user->id]);
        $this->actingAs($user2);
        
        $response = $this->get('/tasks/'. $task->id .'/edit');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_create_new_task()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->call('POST', '/tasks',
            [
                'name' => 'test',
                'days' => 1,
                'project_id' => $project->id,
            ]
        );
        $this->assertEquals(302, $response->getStatusCode());
        $response->assertRedirect('/tasks');
    }

    /** @test */
    public function user_update_project()
    {
        $user = factory(User::class)->create();
        $task = factory(Task::class)->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->call('PUT', '/tasks/'.$task->id,
            [
                'name' => 'test',
                'days' => 1,
            ]
        );
        $this->assertEquals(302, $response->getStatusCode());
        $response->assertRedirect('/tasks/'.$task->id);
    }

    /** @test */
    public function user_add_member_to_task()
    {
        $user = factory(User::class)->create();
        $task = factory(Task::class)->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->call('POST', '/tasks/adduser',
            [
                'email' => $user->email,
                'task_id' => $task->id,
            ]
        );

        $this->assertEquals(302, $response->getStatusCode());
        $response->assertRedirect('/tasks/' .$task->id);
    }
}