<?php
namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImageUploadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * it can upload a image
     *
     * @test
     */
    public function it_can_upload_a_image()
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('image.jpg', 400, 500);

        $this->be($this->user, 'api')
            ->postJson('api/image-upload', ['image' => $image])
            ->assertStatus(200)
            ->assertJson(['url' => '/storage/uploads/' . $image->hashName()]);

        Storage::disk('public')->assertExists('uploads/' . $image->hashName());
    }

    /**
     * image upload validation must be image
     *
     * @test
     */
    public function image_upload_validation_must_be_image()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('image.pdf', 10);

        $this->be($this->user, 'api')
            ->postJson('api/image-upload', ['image' => $file])
            ->assertStatus(422);

        Storage::disk('public')->assertMissing('uploads/' . $file->hashName());
    }

    /**
     * it can upload a post featured image
     *
     * @test
     */
    public function it_can_upload_a_post_featured_image()
    {
        Storage::fake('public');
        $post = factory(Post::class)->create(['featured_image' => null, 'user_id' => $this->user->id]);
        $image = UploadedFile::fake()->image('image.jpg', 400, 500);

        $this->be($this->user, 'api')
            ->postJson('api/image-upload', ['image' => $image, 'post_id' => $post->id])
            ->assertStatus(200)
            ->assertJson(['url' => '/storage/uploads/' . $image->hashName()]);

        Storage::disk('public')->assertExists('uploads/' . $image->hashName());
        $post = $post->fresh();
        $this->assertNotNull($post->featured_image);
        $this->assertEquals('/storage/uploads/' . $image->hashName(), $post->featured_image);
    }
}
