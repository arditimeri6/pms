<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function setup()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
    }    

    /** @test */
    public function admin_visit_users_page()
    {
    	$user = factory(User::class)->create();
        $user->assignRole('admin');
    	$this->actingAs($user);

 		$response = $this->get('/users');
 		$response->assertSee($user->name);
 		$response->assertStatus(200);
    }

    /** @test */ 
    public function admin_visit_edit_users_page()
    {
    	$user = factory(User::class)->create();
        $user->assignRole('admin');
    	$this->actingAs($user);

 		$response = $this->get('/users/'. $user->id . '/edit');
 		$response->assertStatus(200);
    }

    /** @test */ 
    public function admin_update_user()
    {
        $user = factory(User::class)->create();
        $user->assignRole('admin');
        $this->actingAs($user);
        $response = $this->call('PUT', '/users/'.$user->id,
            [
                'name' => 'test',
                'email' => 'test@gmail.com',
            ]
        );
        $this->assertEquals(302, $response->getStatusCode());
        $response->assertRedirect('/users');
    }

    /** @test */
    public function user_try_to_access_users_page()
    {
        $user = factory(User::class)->create();
        $user->assignRole('user');
        $this->actingAs($user);

        $response = $this->get('/users');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_try_to_access_users_edit_page()
    {
        $user = factory(User::class)->create();
        $user->assignRole('user');
        $this->actingAs($user);

        $response = $this->get('/users/'. $user->id . '/edit');
        $response->assertStatus(403);
    }
}