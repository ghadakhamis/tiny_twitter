<?php namespace App\Http\Repositories;

use App\Http\Models\User;
use Czim\Repository\BaseRepository;

class UserRepository extends BaseRepository {

    /**
     * Returns specified model class name.
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    public function getUserByEmail(String $email){
        return $this->model->select('*')
            ->where('email',$email)
            ->first();
    }
}