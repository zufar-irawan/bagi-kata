<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Table(key: 'id', keyType: 'string', incrementing: false)]
class Posts extends Model
{
    use HasUlids;
    use SoftDeletes;

    protected $table = "posts";
    protected $fillable = ['user_id', 'text_content', 'image', 'file', 'parent_id', 'thread_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'post_tag', 'post_id', 'tag_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id')->withTrashed();
    }

    public function thread()
    {
        return $this->belongsTo(self::class, 'thread_id');
    }

    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function likes()
    {
        return $this->hasMany(Likes::class, 'post_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorites::class, 'post_id');
    }
}
