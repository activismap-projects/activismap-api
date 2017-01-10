<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 4/10/16
 * Time: 1:45
 */

namespace ActivisMap\Controller;


use ActivisMap\Base\EntityController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @package ActivisMap\Controller
 * @Route("/v1/user")
 */
class UserController extends EntityController {

    /**
     * @Route("")
     * @Method("GET")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function self(Request $request) {
        $user = $this->getUser();

        return $this->rest($user->getBaseView());
    }

    /**
     * @Route("")
     * @Method("PUT")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateSelf(Request $request) {
        $user = $this->getUser();

        return $this->rest($user->getBaseView());
    }

    /**
     * @Route("/account/{usrId}")
     * @Method("GET")
     * @param Request $request
     * @param $usrId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAccount(Request $request, $usrId) {
        $user = $this->getUser($usrId);

        return $this->rest($user->getBaseView());
    }

    protected function getRepositoryName()
    {
        return 'ActivisMap:User';
    }
}