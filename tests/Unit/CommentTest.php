<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use App\Comment;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
	use RefreshDatabase;
    /** @test */
    public function user_create_new_comment()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->call('POST', '/comments',
            [
                'url' => 'test',
                'body' => 'test',
                'commentable_id' => 1,
                'commentable_type' => 'App\Company',
            ]
        );
        $this->assertEquals(302, $response->getStatusCode());
    }
}
