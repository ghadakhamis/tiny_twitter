<?php namespace App\Http\Services;

use Illuminate\Database\DatabaseManager;

abstract class BaseService{

    protected $repository, $database;
   
    public function __construct()
    {
    }

    protected function setDatabase($database){
        $this->database = $database;
    }

    protected function setRepository($repository){
        $this->repository = $repository;
    }
}
