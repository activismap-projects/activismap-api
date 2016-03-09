<?php

namespace AppBundle\Controller;

use AppBundle\Base\ApiController;
use AppBundle\Base\CRUDApiController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class GroupController
 * @package AppBundle\Controller
 * @Route("/admin/v1/groups")
 */
class GroupController extends CRUDApiController{

    protected function getRepositoryName()
    {
        return "AppBundle:Group";
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