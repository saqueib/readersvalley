<?php
namespace Tests\Unit;

use App\Tag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    /**
     * it can get tag by slug or id
     *
     * @test
     */
    public function it_can_get_tag_by_slug_or_id()
    {
        $tag = factory(Tag::class)->create(['name' => 'Moon', 'slug' => 'moons']);

        // get it by id
        $this->assertEquals($tag->id, Tag::getBySlugOrId($tag->id)->id);

        // get it by slug
        $this->assertEquals($tag->slug, Tag::getBySlugOrId('moons')->slug);
    }
}
