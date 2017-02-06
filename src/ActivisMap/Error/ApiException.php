<?php

namespace ActivisMap\Error;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Created by PhpStorm.
 * User: ander
 * Date: 4/11/16
 * Time: 16:06
 */
class ApiException extends \RuntimeException implements ApiError{

    private $error;
    private $data;
    private $httpCode;

    /**
     * @param array $apiError
     * @param null $data
     */
    public function __construct($apiError, $data = null) {
        $this->error = $apiError['error'];
        $this->httpCode = $apiError['httpCode'];

        if ($data == null) {
            $this->data = array(
                'error' => $this->error
            );
        } else {
            $this->data = array(
                'error' => $apiError['error'],
                'message' => $data
            );
        }

        parent::__construct($apiError['error'], $apiError['httpCode'], null);
    }

    /**
     * @return string
     */
    function getError() {
        return $this->error;
    }

    /**
     * @return array
     */
    function getData() {
        return $this->data;
    }

    /**
     * @return int
     */
    function getHttpCode()
    {
        return $this->httpCode;
    }
}