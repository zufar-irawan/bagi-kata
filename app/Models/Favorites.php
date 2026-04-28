<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    use HasUlids;

    protected $table = "favorites";
    protected $fillable = ['user_id', 'post_id'];
}
