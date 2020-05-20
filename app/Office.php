<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable = [
        'name', 'city', 'state', 'image'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
