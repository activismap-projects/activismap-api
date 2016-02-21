<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\ExceptionController;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class ApiExceptionController extends ExceptionController{

    protected function createExceptionWrapper(array $parameters) {
        if (isset($parameters['errors'])) {
            return new RestExceptionWrapper($parameters['status_code'], $parameters['message'], $parameters['errors']);
        }
        return new RestExceptionWrapper("error", $parameters['message']);
    }

    protected function getExceptionMessage($exception){
        return $exception->getMessage();
    }
}

class RestExceptionWrapper {
    private $status;
    private $message;
    private $errors;

    public function __construct($status, $message, $errors = null){
        $this->status = $status;
        $this->message = $message;
        $this->errors = $errors;
    }
}
