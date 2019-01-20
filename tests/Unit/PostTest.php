<?php

namespace Tests\Unit;

use App\Post;
use App\Tag;
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

    /**
     * it can sycn new tags and use existing tag
     *
     * @test
     */
    public function it_can_sycn_new_tags_and_use_existing_tag()
    {
        $post = factory(Post::class)->create();
        factory(Tag::class)->create(['name' => 'Laravel', 'slug' => 'laravel']);
        $post->tags()->sync(Tag::pluck('id'));
        $this->assertCount(1, $post->tags);

        $tags = ['Laravel', 'VueJS'];

        $post->syncTags($tags);

        $this->assertCount(2, $post->fresh()->tags);
        $this->assertDatabaseHas('tags', ['name' => 'VueJS']);
    }
}
