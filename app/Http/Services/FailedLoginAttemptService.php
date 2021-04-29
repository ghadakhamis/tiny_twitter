<?php namespace App\Http\Services;

use Illuminate\Database\DatabaseManager;
use App\Http\Repositories\FailedLoginAttemptRepository;
use App\Http\Services\BaseService;
use Carbon\Carbon;

class FailedLoginAttemptService extends BaseService{
   
    public function __construct(DatabaseManager $database, FailedLoginAttemptRepository $repository )
    {
        $this->setDatabase($database);
        $this->setRepository($repository);
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

    public function checkIfEmailIsBlocked($email){
        $failedCount = $this->repository->getCountOfRecordsByEmail($email);
        $lastFailed = $this->repository->getLastFailedByEmail($email);
        $lastFailedDate = $lastFailed? Carbon::parse($lastFailed->failed_login_time) : Carbon::now();
        $currentDate = Carbon::now();
        if($failedCount >= config('failedLogin.attempts') &&
            $currentDate->diffInMinutes($lastFailedDate) <= config('failedLogin.blockedTimeInMinutes')){
            return true;
        }
        return false;
    }
}