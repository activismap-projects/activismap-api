<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 12/07/16
 * Time: 18:14
 */

namespace ActivisMap\Controller;

use ActivisMap\Base\Neo4jController;
use ActivisMap\Base\NeoQuery;
use ActivisMap\Entity\Application;
use ActivisMap\Entity\User;
use ActivisMap\Util\Area;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class PublicController
 * @package ActivisMap\Controller
 * @Route("/api/v1/public")
 */
class PublicController extends Neo4jController {

    /**
     * @ApiDoc(
     *      section="Público",
     *      description="Registro de usuario",
     *      parameters = {
     *          {"name"="password", "dataType"="string", "required"=true, "format"="UTF-8", "description"="Contraseña para la cuenta"},
     *          {"name"="repassword", "dataType"="string", "required"=true, "format"="UTF-8", "description"="Comprobación de contraseña"},
     *          {"name"="username", "dataType"="string", "required"=false, "format"="UTF-8", "description"="Nombre de usuario para hacer login. Si no se especifica se usará uno generado"},
     *          {"name"="person_name", "dataType"="string", "required"=false, "format"="UTF-8", "description"="Nombre personal del usuario. Si no se especifica se usará el username"},
     *          {"name"="email", "dataType"="string", "required"=false, "format"="UTF-8", "description"="Nombre personal del usuario. Si no se especifica se usará el username"},
     *          {"name"="avatar", "dataType"="string", "required"=false, "format"="UTF-8", "description"="Nombre personal del usuario. Si no se especifica se usará el username"},
     *      },
     *      output = "AppBundle\Entity\NeoUser"
     * )
     * @Route("/app/register")
     * @Method("POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request) {
        $appId = $this->getParameter('application_id');
        $app = $this->getApplication($appId);

        $params = $this->checkParams($request, array('password', 'repassword', 'username', 'email'),
            array('person_name', 'avatar'));

        $password = $params['password'];
        $repassword = $params['repassword'];

        if ($password != $repassword) {
            throw new HttpException(400, 'Password and repassword must match.');
        }

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
        $user->setNeoId(-1);

        $neoUser = $this->saveUser($user, $app);

        $userView = $neoUser->getExtendView();

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
        $offset = 0;

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
                    $acts = $this->getNeoQuery()->searchActivities($type, $startDate, $endDate, $limit, $offset, $a);
                } else {
                    $acts = $this->getNeoQuery()->searchActivities($type, $startDate, $endDate, $limit, $offset);
                }
            } else {
                $acts = $this->getNeoQuery()->searchActivities($type, $startDate, $endDate, $limit, $offset);
            }
        } else {
            $acts = $this->getNeoQuery()->searchActivities($type, $startDate, $endDate, $limit, $offset);
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
        $activity = $this->getActivity($actId);

        $action = strtoupper($params['action']);

        switch ($action) {
            case 'LIKE':
                $activity->like();
                break;
            case 'DISLIKE':
                $activity->dislike();
                break;
            case 'NEUTRAL':
                $activity->removeLike();
                $activity->removeDislike();
                break;
            case 'SUBSCRIBE':
                $activity->incrementParticipants();
                break;
            case 'UNSUBSCRIBE':
                $activity->decrementParticipants();
                break;
        }

        $this->saveInNeo($activity);

        return $this->rest($activity->getExtendView());
    }
}