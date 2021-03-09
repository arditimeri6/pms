<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Company;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class CompanyTest extends TestCase
{
	use RefreshDatabase;

    public function setup()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
    } 
    
    /** @test */
    public function user_visit_company_page()
    {
    	$user = factory(User::class)->create();
    	$this->actingAs($user);

    	$company = factory(Company::class)->create();
 		$response = $this->get('/companies');
 		$response->assertSee($company->name);
 		$response->assertStatus(200);
    }

    /** @test */
    public function user_visit_create_company_page()
    {
    	$user = factory(User::class)->create();
        $user->givePermissionTo('create_company');
    	$this->actingAs($user);

 		$response = $this->get('/companies/create');
 		$response->assertStatus(200);
    }

    /** @test */
    public function user_visit_single_company_page()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $company = factory(Company::class)->create();
        $response = $this->get('/companies/' .$company->id);
        $response->assertStatus(200);
    }

    /** @test */
    public function user_visit_edit_company_page()
    {
    	$user = factory(User::class)->create();
        $user->givePermissionTo('edit_company');
    	$company = factory(Company::class)->create(['user_id' => $user->id]);
    	$this->actingAs($user);

 		$response = $this->get('/companies/'. $company->id . '/edit');
 		$response->assertStatus(200);
    }

    /** @test */
    public function user_try_to_edit_another_users_company()
    {
        $user = factory(User::class)->create();
        $user->givePermissionTo('edit_company');
        $user2 = factory(User::class)->create();
        $user2->givePermissionTo('edit_company');
        $company = factory(Company::class)->create(['user_id' => $user->id]);
        
        $this->actingAs($user2);
        
        $response = $this->get('/companies/'. $company->id .'/edit');
        $response->assertStatus(403);
    }

    /** @test */
    public function user_create_new_company()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->call('POST', '/companies',
            [
                'name' => 'test',
                'description' => 'test',
            ]
        );
        $this->assertEquals(302, $response->getStatusCode());
        $response->assertRedirect('/companies');
    }

    /** @test */
    public function user_update_company()
    {
        $user = factory(User::class)->create();
        $company = factory(Company::class)->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->call('PUT', '/companies/'.$company->id,
            [
                'name' => 'test',
                'description' => 'test',
            ]
        );
        $this->assertEquals(302, $response->getStatusCode());
        $response->assertRedirect('/companies/'.$company->id);
    }
}