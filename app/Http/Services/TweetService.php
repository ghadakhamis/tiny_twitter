<?php namespace App\Http\Services;

use Illuminate\Database\DatabaseManager;
use App\Http\Repositories\TweetRepository;
use Carbon\Carbon;

class TweetService{

    private $repository, $database;
   
    public function __construct(DatabaseManager $database, TweetRepository $repository )
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

}