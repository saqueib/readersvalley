<?php
namespace Tests\Feature;

use App\Tag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    protected $tags;

    public function setUp()
    {
        parent::setUp();

        $this->tags = ['Laravel', 'VueJS', 'React', 'PHP', 'JavaScript'];

        foreach ($this->tags as $tag) {
            factory(Tag::class)->create(['name' => $tag, 'slug' => str_slug($tag)]);
        }
    }
    /**
     * user can search for tags
     *
     * @test
     */
    public function user_can_search_for_tags()
    {
        factory(Tag::class)->create(['name' => 'Mindvalley', 'slug' => 'mv']);

        // search with name
        $this->be($this->user, 'api')
            ->getJson('api/tags?q=java')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    ['name' => 'JavaScript', 'slug' => 'javascript']
                ]
            ]);

        // search with slug
        $this->be($this->user, 'api')
            ->getJson('api/tags?q=mv')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    ['name' => 'Mindvalley', 'slug' => 'mv']
                ]
            ]);
    }

    /**
     * user can get all tags
     *
     * @test
     */
    public function user_can_get_all_tags()
    {
        $this->be($this->user, 'api')
            ->getJson('api/tags')
            ->assertStatus(200)
            ->assertJson([
                'data' => Tag::all()->only('name', 'slug')->toArray()
            ]);
    }

    /**
     * user can add new tags
     *
     * @test
     */
    public function user_can_add_new_tags()
    {
        $payload = ['name' => 'NodeJs'];

        $this->be($this->user, 'api')
            ->postJson('api/tags', $payload)
            ->assertStatus(201);

        $this->assertDatabaseHas('tags', $payload);
    }

    /**
     * user can update a tag name and slug
     *
     * @test
     */
    public function user_can_update_a_tag_name_and_slug()
    {
        $tag = factory(Tag::class)->create(['name' => 'Moon', 'slug' => 'moons']);

        $payload = ['name' => 'Moon.js', 'slug' => 'moony'];

        $this->be($this->user, 'api')
            ->putJson('api/tags/'.$tag->slug, $payload)
            ->assertStatus(200);

        $this->assertDatabaseHas('tags', $payload);
    }

    /**
     * user can delete a tag
     *
     * @test
     */
    public function user_can_delete_a_tag()
    {
        $this->be($this->user, 'api')
            ->deleteJson('api/tags/php')
            ->assertStatus(200);

        $this->assertDatabaseMissing('tags', ['name' => 'PHP']);
    }
}
