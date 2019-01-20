<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
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
