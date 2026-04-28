<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $table = "tags";
    protected $fillable = ['name'];

    public function posts()
    {
        return $this->belongsToMany(Posts::class, 'post_tag', 'tag_id', 'post_id');
    }
}
