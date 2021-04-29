<?php namespace App\Http\Services;

use Illuminate\Database\DatabaseManager;

class BaseService{

    protected $repository, $database;
   
    public function __construct()
    {
    }

    protected function setDatabase(){
        $this->database = $database;
    }

    protected function setRepository(){
        $this->repository = $repository;
    }
}