<?php

namespace AppBundle\Controller;

use AppBundle\Base\ApiController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HelloController extends ApiController
{
    /**
     * @Route("/hello/{name}", name="hello")
     */
    public function indexAction(Request $request, $name = "Jenkins")
    {
        return $this->rest(array("provided_name" => $name), "success", "Hello did OK");
    }
}
