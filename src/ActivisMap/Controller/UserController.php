<?php

namespace ActivisMap\Controller;

use ActivisMap\Base\ApiController;
use ActivisMap\Base\CRUDApiController;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class UserController
 * @package ActivisMap\Controller
 * @Route("/admin/v1/users")
 */
class UserController extends CRUDApiController{


    protected function getRepositoryName()
    {
        return "ActivisMap:User";
    }

    /**
     * @Route("/")
     * @Method("GET")
     */
    public function index(Request $request)
    {
        return parent::index($request);
    }

    /**
     * @Route("/{id}")
     * @Method("GET")
     */
    public function show(Request $request, $id)
    {
        return parent::show($request, $id);
    }

    /**
     * @Route("/")
     * @Method("POST")
     */
    public function create(Request $request)
    {
        return parent::create($request);
    }

    /**
     * @Route("/{id}")
     * @Method("PUT")
     */
    public function update(Request $request, $id)
    {
        return parent::update($request, $id);
    }

    /**
     * @Route("/{id}")
     * @Method("DELETE")
     */
    public function delete(Request $request, $id)
    {
        return parent::delete($request, $id);
    }

}
