<?php

namespace App\Http\Models;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tweet extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'tweet_body', 'user_id'
    ];

    public static function rules($action)
    {
        switch ($action) {
            case 'store':
                return array(
                    'tweet_body'=> 'required|max:140',
                    'user_id' => 'required'
                );
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}