<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function syncTags(array $tags)
    {
        $allTags = collect($tags)->map(function ($tag) {
            $slug = str_slug($tag);
            if ($tagFound = Tag::whereSlug($slug)->first()) {
                return $tagFound->id;
            }

            return Tag::create(['name' => $tag, 'slug' => $slug])->id;
        })->toArray();

        // sync the tags with post
        $this->tags()->sync($allTags);
    }

    /**
     * Scope query to only include published posts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }
}
