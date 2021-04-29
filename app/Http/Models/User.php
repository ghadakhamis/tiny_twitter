<?php

namespace App\Http\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'profile_image','date_of_birth'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public static function rules($action)
    {
        switch ($action) {
            case 'register':
                return array(
                    'name'=> 'required|max:200',
                    'email'=> 'required|email|unique:users',
                    'password' => 'required|min:6',    
                    'profile_image'=> 'required',
                    'date_of_birth'=> 'required|date|before:today',
                );
            case 'login':
                return array(
                    'email'=> 'required|email',
                    'password' => 'required|min:6',    
                );
        }
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }  
    
    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }

    // users that are followed by this user
    public function following() {
        return $this->belongsToMany(User::class, 'user_following', 'follower_id', 'followed_id');
    }

    // users that follow this user
    public function followers() {
        return $this->belongsToMany(User::class, 'user_following', 'followed_id', 'follower_id');
    }
}
