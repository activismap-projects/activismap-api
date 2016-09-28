<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 12/07/16
 * Time: 20:14
 */

namespace ActivisMap\Controller;

use ActivisMap\Base\Neo4jController;
use ActivisMap\Entity\Application;
use ActivisMap\Entity\NeoUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class AdminController
 * @package AppBundle\Controller
 * @Route("/api/v1/admin")
 */
class AdminController extends Neo4jController {

    /**
     * @ApiDoc(
     *      section="Administración",
     *      description="Crear nueva Aplicacion",
     *      parameters = {
     *          {"name"="name", "dataType"="string", "required"=true, "format"="UTF-8", "description"="Nombre de la aplicación"}
     *      },
     *      output = "AppBundle\Entity\Application"
     * )
     * @Route("/createApp")
     * @Method("POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createApplication(Request $request) {
        $params = $this->checkParams($request, array('name'));

        $app = new Application();
        $app->setName($params['name']);
        $this->saveInNeo($app);

        return $this->rest($app);
    }

    /**
     * @ApiDoc(
     *      section="Administración",
     *      description="Modificar una aplicación",
     *      requirements = {
     *          {"name"="appId", "dataType"="integer", "requirement"=true, "description"="Identificador de la aplicación"}
     *      },
     *      parameters = {
     *          {"name"="name", "dataType"="string", "required"=true, "format"="UTF-8", "description"="Nombre de la aplicación"}
     *      },
     *      output = "AppBundle\Entity\Application"
     * )
     * @Route("/app/{appId}")
     * @Method("PUT")
     * @param Request $request
     * @param $appId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateApp(Request $request, $appId) {
        $app = $this->update($request, $this->getApplicationRepository(), $appId);
        return $this->rest($app, 'ok', 'Application update successfully');

    }

}