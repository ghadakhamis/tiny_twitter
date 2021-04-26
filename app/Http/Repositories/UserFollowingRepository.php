<?php namespace App\Http\Repositories;

use App\Http\Models\UserFollowing;
use Czim\Repository\BaseRepository;

class UserFollowingRepository extends BaseRepository {

    /**
     * Returns specified model class name.
     *
     * @return string
     */
    public function model()
    {
        return UserFollowing::class;
    }
}