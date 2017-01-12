<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 12/07/16
 * Time: 18:14
 */

namespace ActivisMap\Controller;

use ActivisMap\Base\ApiController;
use ActivisMap\Entity\Company;
use ActivisMap\Entity\User;
use ActivisMap\Util\Area;
use ActivisMap\Util\Roles;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class PublicController
 * @package ActivisMap\Controller
 * @Route("/v1/public")
 */
class PublicController extends ApiController {

    /**
     * @Route("/register")
     * @Method("POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request) {

        $params = $this->checkParams($request, array('password', 'username', 'email'),
            array('person_name'));

        $password = $params['password'];

        $username = $params['username'];
        $personName = array_key_exists('person_name', $params) ? $params['person_name'] : $username;

        $users = $this->getManager()
            ->getRepository('ActivisMap:User')
            ->findBy(array('username' => $username));

        if (count($users) > 0) {
            throw new HttpException(400, 'Username already exist');
        }

        $user = new User();
        $user->setPlainPassword($password);
        $user->setUsername($username);
        $user->setEmail($params['email']);
        $user->setPersonName($personName);
        $user->setEnabled(true);

        $this->setImage($request, 'avatar', $user);

        $this->save($user);

        $company = new Company(ucwords($personName));
        $company->setEmail($params['email']);
        $company->setLogo($user->getAvatar());

        $this->save($company);

        $userRoles = $company->getUserRoles($user);
        $userRoles->addRole(Roles::ROLE_SUPER_ADMIN);
        $this->save($userRoles);

        $userView = $user->getExtendView();

        return $this->rest($userView);

    }

    /**
     * @Route("/search")
     * @Method("GET")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchActivities(Request $request) {

        $params = $this->checkParams($request, array(), array('type', 'start_date', 'end_date', 'limit', 'offset', 'area'));

        if (array_key_exists('type', $params)) {
            $type = strtoupper($params['type']);
        } else {
            $type = 'ALL';
        }

        $endDate = 0;
        $startDate = 0;
        $limit = 20;
        $offset = 1;

        if (array_key_exists('end_date', $params)) {
            $endDate = intval($params['end_date']);
        }

        if (array_key_exists('start_date', $params)) {
            $endDate = intval($params['start_date']);
        }

        if (array_key_exists('limit', $params)) {
            $limit = intval($params['limit']);
        }

        if (array_key_exists('offset', $params)) {
            $offset = intval($params['offset']);
        }

        if (array_key_exists('area', $params)) {
            $area = $params['area'];

            if (!strrpos($area, '@') !== true) {
                $point1 = explode('@', $area)[0];
                $point2 = explode('@', $area)[1];

                if (strrpos($point1, ',') !== true && strrpos($point1, ',') !== true) {
                    $lat1 = floatval(explode(',', $point1)[0]);
                    $lng1 = floatval(explode(',', $point1)[1]);
                    $lat2 = floatval(explode(',', $point2)[0]);
                    $lng2 = floatval(explode(',', $point2)[1]);

                    $a = new Area($lat1, $lng1, $lat2, $lng2);
                    $acts = $this->getQueryHelper()->searchEvents($type, $startDate, $endDate, $limit, $offset, $a);
                } else {
                    $acts = $this->getQueryHelper()->searchEvents($type, $startDate, $endDate, $limit, $offset);
                }
            } else {
                $acts = $this->getQueryHelper()->searchEvents($type, $startDate, $endDate, $limit, $offset);
            }
        } else {
            $acts = $this->getQueryHelper()->searchEvents($type, $startDate, $endDate, $limit, $offset);
        }


        return $this->rest($acts);
    }

    /**
     * @Route("/activity/{actId}")
     * @Method("GET")
     * @param Request $request
     * @param $actId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function activityAction(Request $request, $actId) {
        $params = $this->checkParams($request, array('action'));
        $event = $this->getEvent($actId);

        $action = strtoupper($params['action']);

        switch ($action) {
            case 'LIKE':
                $event->like();
                break;
            case 'DISLIKE':
                $event->dislike();
                break;
            case 'NEUTRAL':
                $event->removeLike();
                $event->removeDislike();
                break;
            case 'SUBSCRIBE':
                $event->incrementParticipants();
                break;
            case 'UNSUBSCRIBE':
                $event->decrementParticipants();
                break;
        }

        $this->save($event);

        return $this->rest($event->getExtendView());
    }
}