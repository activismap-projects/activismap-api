<?php

namespace AppBundle\Controller;

use AppBundle\Base\ApiController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class HelloController extends ApiController
{
    /**
     * @Route("/public/hello/{name}")
     * @Method("GET")
     */
    public function helloPublicAction(Request $request, $name = "Jenkins")
    {
        return $this->rest(array("provided_name" => $name), "success", "Hello did OK");
    }

    /**
     * @Route("/hello/{name}")
     * @Method("GET")
     */
    public function helloAction(Request $request)
    {
        $user = $this->get("security.token_storage")->getToken()->getUser();
        return $this->rest(
            array("name" => $user->getName()),
            "success",
            "Hello did OK"
        );
    }
}
