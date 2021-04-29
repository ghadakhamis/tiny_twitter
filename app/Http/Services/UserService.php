<?php namespace App\Http\Services;

use Illuminate\Database\DatabaseManager;
use App\Http\Repositories\UserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;
use Hash;

class UserService extends BaseService{

    public function __construct(DatabaseManager $database, UserRepository $repository )
    {
        $this->setDatabase($database);
        $this->setRepository($repository);
    }

    public function create(array $data){
        $this->database->beginTransaction();

        try {
            $data['password'] = Hash::make($data['password']);
            $model = $this->repository->create($data);
        } catch (Exception $e) {
            $this->database->rollBack();
            throw $e;
        }

        $this->database->commit();

        return $model;
    }

    public function loginUser(String $email,String $password){
        $user = $this->repository->getUserByEmail($email);
        if($user && Hash::check($password,$user->password)){
            return $user;
        }
        return null;
    }

    public function getCurrentUser(){
        $user = null;
        $userData = JWTAuth::parseToken()->authenticate();
        if($userData){
            $user = $this->repository->find($userData->id,array('*'));
        }
        return $user;
    }

    public function getUsersWithTweetsCount(){
        return $this->repository->getUsersWithTweetsCount();
    }
}