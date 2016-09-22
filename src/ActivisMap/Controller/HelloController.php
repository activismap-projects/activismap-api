<?php

namespace ActivisMap\Controller;

use ActivisMap\Base\ApiController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class HelloController extends ApiController
{
    /**
     * @Route("/public/v1/hello/{name}")
     * @Method("GET")
     */
    public function helloPublicAction(Request $request, $name = "Jenkins")
    {
        return $this->rest(array("provided_name" => $name), "success", "Hello did OK");
    }

    /**
     * @Route("/user/v1/hello")
     * @Method("GET")
     */
    public function helloAction(Request $request)
    {
        $user = $this->get("security.token_storage")->getToken()->getUser();
        return $this->rest(
            array("name" => $user->getUsername()),
            "success",
            "Hello did OK"
        );
    }
}
