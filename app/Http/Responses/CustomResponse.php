<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class CustomResponse implements Responsable
{
    private $results, $errors, $messages, $statusCode;

    public function __construct()
    {
    }

    public function response($results, Array $messages, Array $errors,int $statusCode)
    {
        $this->results = $results;
        $this->errors = $errors;
        $this->messages = $messages;
        $this->statusCode = $statusCode;
        return $this;
    }


    /**
     * Create an HTTP response that represents the object.
     *
     */
    public function toResponse($request)
    {
        return response()->json(['results' => $this->results, 'messages' => $this->messages,'errors' => $this->errors] , $this->statusCode);
    }
}