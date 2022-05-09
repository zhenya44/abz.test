<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class Token extends Model
{
    protected $fillable = [
        'token', 'created_at', 'expires_at'
    ];

    public $timestamps = false;

    public function isExpired()
    {
        return $this->expires_at <= Date::now()->format('Y-m-d H:i:s');
    }

}
