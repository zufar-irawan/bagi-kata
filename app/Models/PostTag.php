<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    use HasUlids;

    protected $table = "post_tag";
    protected $fillable = ['post_id', 'tag_id'];
}
