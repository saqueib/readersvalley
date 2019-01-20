<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * Get tag by ID or Slug
     *
     * @param $id string|integer
     * @return self
     */
    public static function getBySlugOrId($id)
    {
        return is_numeric($id) ? Tag::findOrFail($id) : Tag::whereSlug($id)->first();
    }
}
