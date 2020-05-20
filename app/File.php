<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['path'];

    protected $hidden = ['created_at', 'updated_at'];
}
