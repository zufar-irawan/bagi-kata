<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    use HasUlids;

    protected $table = "likes";
    protected $fillable = ['user_id', 'post_id'];
}
