<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ImageUploadRequest;

class ImageUploadController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ImageUploadRequest $request)
    {
        $path = $request->image->store(config('readers.upload_path'), [
                'disk' => config('readers.upload_disk'),
                'visibility' => 'public',
            ]
        );

        $url = Storage::disk(config('readers.upload_disk'))->url($path);

        // check if post_id present
        if($request->has('post_id') && $path) {
            $post = $this->me()->posts()->find($request->get('post_id'));

            // old featured image
            $oldImage = $post->featured_image;
            $post->update(['featured_image' => $url]);

            // clean up
            if(Storage::disk(config('readers.upload_disk'))->exists($oldImage)) {
                Storage::disk(config('readers.upload_disk'))->delete($oldImage);
            }
        }

        return response()->json([
            'url' => $url,
        ]);
    }
}
