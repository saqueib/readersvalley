<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePostRequest $request
     * @return PostResource
     */
    public function store(StorePostRequest $request)
    {
        $post = $this->me()->posts()->create($request->only(['title', 'body', 'slug']));

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return PostResource
     */
    public function show($id)
    {
        return new PostResource($this->me()->posts()->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePostRequest $request
     * @param  int $id
     * @return void
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $post = $this->me()->posts()->findOrFail($id);
        $post->fill($request->only(['title', 'body', 'slug']));

        // is a published request
        if( $publishedAt = $request->get('published_at')) {

            // check for tags
            abort_unless($this->hasTags($request, $post), 400,
                'Post must have atleast one tag assigned before publishing.'
            );

            $post->published_at = Carbon::parse($publishedAt)->toDateTimeString();
        }

        // sync tags
        if($tags = $request->get('tags', [])) {
            $post->syncTags($tags);
        }

        $post->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Check if post or request as tags
     *
     * @param UpdatePostRequest $request
     * @param $post
     *
     * @return bool
     */
    protected function hasTags(UpdatePostRequest $request, $post)
    {
        return $post->tags->count() > 0 || $request->has('tags');
    }
}
