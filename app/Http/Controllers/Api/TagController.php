<?php

namespace App\Http\Controllers\Api;

use App\Tag;
use App\Http\Resources\TagResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::when(\request('q'), function ($q) {
            return $q->where('name', 'LIKE', '%' . request('q') . '%')
                ->orWhere('slug', 'LIKE', '%' . request('q') . '%');
        })->withCount('posts')->paginate();

        return TagResource::collection($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTagRequest $request
     * @return TagResource
     */
    public function store(StoreTagRequest $request)
    {
        $tag = Tag::firstOrNew(['slug' => str_slug($request->get('name'))]);
        $tag->name = $request->get('name');
        $tag->save();

        return new TagResource($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTagRequest $request
     * @param  int $id
     * @return void
     */
    public function update(UpdateTagRequest $request, $id)
    {
        Tag::getBySlugOrId($id)->update($request->only(['name', 'slug']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tag::getBySlugOrId($id)->delete();

        return '';
    }
}
