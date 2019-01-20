<?php

namespace Tests\Feature;

use App\Post;
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

    /**
     * a post title is required
     *
     * @test
     */
    public function a_post_title_is_required()
    {
        $payload = [
            'body' => 'this is draft post body',
            'slug' => 'draft-post'
        ];

        $this->be($this->user, 'api')
            ->postJson('api/posts', $payload)
            ->assertStatus(422);

        $this->assertDatabaseMissing('posts', $payload);
    }

    /**
     * a post body is required
     *
     * @test
     */
    public function a_post_body_is_required()
    {
        $payload = [
            'title' => 'Draft post',
            'slug' => 'draft-post'
        ];

        $this->be($this->user, 'api')
            ->postJson('api/posts', $payload)
            ->assertStatus(422);

        $this->assertDatabaseMissing('posts', $payload);
    }

    /**
     * a post slug is required
     *
     * @test
     */
    public function a_post_slug_is_required()
    {
        $payload = [
            'title' => 'Draft post',
            'body' => 'this is draft post body',
        ];

        $this->be($this->user, 'api')
            ->postJson('api/posts', $payload)
            ->assertStatus(422);

        $this->assertDatabaseMissing('posts', $payload);
    }

    /**
     * a post slug must be unique
     *
     * @test
     */
    public function a_post_slug_must_be_unique()
    {
        factory(Post::class)->create(['slug' => 'i-am-unique-in-this-world']);

        $payload = [
            'title' => 'Draft post',
            'body' => 'this is draft post body',
            'slug' => 'i-am-unique-in-this-world'
        ];

        $this->be($this->user, 'api')
            ->postJson('api/posts', $payload)
            ->assertStatus(422)
            ->assertSee('The slug has already been taken');

        $this->assertDatabaseMissing('posts', $payload);
    }
}
