<?php namespace App\Http\Services;

use Illuminate\Database\DatabaseManager;
use App\Http\Repositories\UserFollowingRepository;
use Carbon\Carbon;

class UserFollowingService{

    private $repository, $database;
   
    public function __construct(DatabaseManager $database, UserFollowingRepository $repository )
    {
        $this->database = $database;
        $this->repository = $repository;
    }

    public function create(array $data){
        $this->database->beginTransaction();

        try {
            $model = $this->repository->create($data);
        } catch (Exception $e) {
            $this->database->rollBack();
            throw $e;
        }

        $this->database->commit();

        return $model;
    }

    public function checkIfCurrentUserFollowingSelectedUser($currentUserId,$followedId){
        $record = $this->repository->checkIfCurrentUserFollowingSelectedUser($currentUserId,$followedId);
        return $record? true : false;
    }

}