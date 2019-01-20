<?php
namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;
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
}
