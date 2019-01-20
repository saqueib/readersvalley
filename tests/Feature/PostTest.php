<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }
    /**
     * guest cannot create a post
     *
     * @test
     */
    public function guest_cannot_create_a_post()
    {
        $payload = [
            'title' => 'Draft post',
            'body' => 'this is draft post body',
            'slug' => 'draft-post'
        ];

        $this->postJson('api/posts', $payload)
            ->assertStatus(401);

        $this->assertDatabaseMissing('posts', $payload);
    }

    /**
     * auth user can create a post
     *
     * @test
     */
    public function auth_user_can_create_a_post()
    {
        $payload = [
            'title' => 'Draft post',
            'body' => 'this is draft post body',
            'slug' => 'draft-post'
        ];

        $this->be($this->user, 'api')
            ->postJson('api/posts', $payload)
            ->assertStatus(201);

        $this->assertDatabaseHas('posts', $payload);
    }
}
