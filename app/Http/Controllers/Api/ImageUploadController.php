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

        return response()->json([
            'url' => Storage::disk(config('readers.upload_disk'))->url($path),
        ]);
    }
}
