<?php

namespace App\Http\Models;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FailedLoginAttempt extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'email', 'failed_login_time', 'IP'
    ];

}