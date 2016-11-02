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
     * @Route("/search/{type}/{category}")
     * @Method("GET")
     * @param Request $request
     * @param $type
     * @param $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchActivities(Request $request, $type, $category) {
        $acts = $this->getNeoQuery()->searchActivities($type, $category);

        return $this->rest($acts);
    }
}