<?php

namespace Core;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent {
    public $timestamps = true; // Enable timestamps
    protected $primaryKey = 'id'; // Default primary key
    protected $guarded = []; // Allow mass assignment

    protected static function boot() {
        parent::boot();
    }
}
