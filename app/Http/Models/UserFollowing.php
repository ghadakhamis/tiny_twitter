<?php

namespace App\Http\Models;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFollowing extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'followed_id', 'follower_id'
    ];

    public static function rules($action)
    {
        switch ($action) {
            case 'store':
                return array(
                    'followed_id'=> 'required',
                    'follower_id' => 'required'
                );
        }
    }
}