<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 4/10/16
 * Time: 1:45
 */

namespace ActivisMap\Controller;


use ActivisMap\Base\EntityController;
use ActivisMap\Entity\Company;
use ActivisMap\Entity\UserCompany;
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

        return $this->rest($user->getExtendView());
    }

    /**
     * @Route("")
     * @Method("POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateSelf(Request $request) {
        $user = $this->getUser();

        return $this->rest($user->getBaseView());
    }

    /**
     * @Route("/companies")
     * @Method("GET")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCompanies(Request $request) {
        $user = $this->getUser();
        $companies = $user->getCompanies();
        $companiesView = array();

        /** @var UserCompany $c */
        foreach ($companies as $c) {
            $companiesView[] = $c->getUserView();
        }

        return $this->rest($companiesView);
    }

    /**
     * @Route("/events")
     * @Method("GET")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getManagedActivities(Request $request) {
        $user = $this->getUser();

        $params = $this->checkParams($request, array(), array('offset', 'limit'));

        $offset = 0;
        if (array_key_exists('offset', $params)) {
            $offset = intval($params['offset']);
        }

        $limit = 0;
        if (array_key_exists('limit', $params)) {
            $limit = intval($params['limit']);
        }


        $acts = $user->getCreatedEvents();


        return $this->rest($acts);
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