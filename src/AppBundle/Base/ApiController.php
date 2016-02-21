<?php

namespace AppBundle\Base;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;


class ApiController extends FOSRestController{
    public function rest($data = null, $status = "ok", $message = "Request success", $httpCode = 200){
        $response = new ApiResponse(
            $data,$status,$message
        );
        return $this->handleView($this->view($response, $httpCode));
    }
}
