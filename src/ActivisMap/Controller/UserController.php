<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 4/10/16
 * Time: 1:45
 */

namespace ActivisMap\Controller;


use ActivisMap\Base\Neo4jController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @package ActivisMap\Controller
 * @Route("/api/v1/user")
 */
class UserController extends Neo4jController {

    /**
     * @Route("")
     * @Method("GET")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function self(Request $request) {
        $user = $this->getNeoUser(null, true);

        return $this->rest($user->getExtendView());
    }

    /**
     * @Route("")
     * @Method("PUT")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateSelf(Request $request) {
        $user = $this->getNeoUser(null, true);

        return $this->rest($user->getExtendView());
    }

    /**
     * @Route("/account/{usrId}")
     * @Method("GET")
     * @param Request $request
     * @param $usrId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAccount(Request $request, $usrId) {
        $user = $this->getNeoUser($usrId, true);

        return $this->rest($user->getBaseView());
    }
}