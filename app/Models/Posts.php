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
}
