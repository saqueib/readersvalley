<?php
namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * a user can access create new post page
     *
     * @test
     */
    public function a_user_can_access_create_new_post_page()
    {
        $this->be($this->user)
            ->get('posts/create')
            ->assertStatus(200)
            ->assertViewIs('post.create');
    }

    /**
     * a user can see list of his posts
     *
     * @test
     */
    public function a_user_can_see_list_of_his_posts()
    {
        factory(Post::class, 4)->create(['user_id' => $this->user->id]);

        $this->be($this->user)
            ->get('posts')
            ->assertStatus(200)
            ->assertViewIs('post.index')
            ->assertViewHas('posts');
    }

    /**
     * user can access edit post page
     *
     * @test
     */
    public function user_can_access_edit_post_page()
    {
        $post = factory(Post::class)->create(['user_id' => $this->user->id]);

        $this->be($this->user)
            ->get('posts/'.$post->id.'/edit')
            ->assertStatus(200)
            ->assertViewIs('post.edit')
            ->assertViewHas('post');
    }
}
