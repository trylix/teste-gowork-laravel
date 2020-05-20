<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'is_company',
        'document',
        'plan_id',
        'office_id',
      ];

      protected $hidden = [
        'plan_id',
        'office_id',
        'created_at',
        'updated_at',
      ];

      public function plan() {
        return $this->belongsTo(Plan::class, 'plan_id');
      }

      public function office() {
        return $this->belongsTo(Office::class, 'office_id');
      }
}
