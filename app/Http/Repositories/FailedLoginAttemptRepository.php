<?php namespace App\Http\Repositories;

use App\Http\Models\FailedLoginAttempt;
use Czim\Repository\BaseRepository;

class FailedLoginAttemptRepository extends BaseRepository {

    /**
     * Returns specified model class name.
     *
     * @return string
     */
    public function model()
    {
        return FailedLoginAttempt::class;
    }

    public function getCountOfRecordsByEmail($email){
        return $this->model->where('email',$email)
            ->count();
    }

    public function getLastFailedByEmail($email){
        return $this->model->where('email',$email)
            ->latest('id')->first();
    }
}