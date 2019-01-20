<?php

namespace Tests\Unit;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * scope to only published posts
     *
     * @test
     */
    public function scope_to_only_published_posts()
    {
        $post = factory(Post::class)->create();
        $unPublishedPost = factory(Post::class)->create(['published_at' => null]);

        $this->assertCount(1, Post::published()->get());
        $this->assertEquals($post->title, Post::published()->first()->title);
        $this->assertNotEquals($unPublishedPost->title, Post::published()->first()->title);
    }
}
