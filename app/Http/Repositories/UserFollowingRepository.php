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

    public function checkIfCurrentUserFollowingSelectedUser($currentUserId,$followedId){
        return $this->model->whereRaw('follower_id = ? AND followed_id = ?',array($currentUserId,$followedId))
            ->first();
    }
}