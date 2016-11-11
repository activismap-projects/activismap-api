<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 23/09/16
 * Time: 1:32
 */

namespace ActivisMap\Controller;

use ActivisMap\Base\Neo4jController;
use ActivisMap\Entity\Activity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ActivityController
 * @package ActivisMap\Controller
 * @Route("/api/v1/activity")
 */
class ActivityController extends Neo4jController {

    /**
     * @Route("")
     * @Method("POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createActivity(Request $request) {
        $app = $this->getApplication($this->getParameter('application_id'));
        $user = $this->getNeoUser();
        //die(print_r('caca', true));

        $params = $this->checkParams($request, array(
            'title', 'description', 'start_date', 'categories', 'type', 'lat', 'lon', 'end_date'),
            array('image64', 'image_name'));

        $files = $this->checkFiles($request, array(), array('image'));

        $act = new Activity();
        $act->setTitle($params['title']);
        $act->setDescription($params['description']);
        $act->setCategories($params['categories']);
        $act->setType($params['type']);
        $act->setCreator($user);
        $act->setStartDate(intval($params['start_date']));
        $act->setLatitude(floatval($params['lat']));
        $act->setLongitude(floatval($params['lon']));
        $act->setEndDate(intval($params['end_date']));
        $act->setApplication($app);

        if (array_key_exists('image', $files)) {
            $fileData = $this->saveFile($files['image']);
            $act->setImage($fileData['url']);
        } else if (array_key_exists('image64', $params)) {
            if (array_key_exists('image_name', $params)) {
                $fileData = $this->saveFile64($params['image_name'], $params['image64']);
                $act->setImage($fileData['url']);
            } else {
                throw new HttpException(400, "Param 'image_name' not provided");
            }
        }

        $this->saveInNeo($act);

        return $this->rest($act->getExtendView());
    }

    /**
     * @Route("/{actId}")
     * @Method("POST")
     * @param Request $request
     * @param $actId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateActivity(Request $request, $actId) {
        $act = $this->getActivity($actId);
        $user = $this->getNeoUser();

        if (!$act->isManager($user)) {
            throw new HttpException(401, 'You do not have necessary permissions');
        }

        /** @var Activity $act */
        $act = parent::update($request, $this->getActivityRepository(), $actId);
        return $this->rest($act->getExtendView());
    }

    /**
     * @Route("/getManagedActivities")
     * @Method("GET")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getManagedActivities(Request $request) {
        $user = $this->getNeoUser();

        $acts = $this->getNeoQuery()->getActivityByUser($user, 'UNVERIFIED', true);
        $acts = array_merge($acts, $this->getNeoQuery()->getActivityByUser($user, 'ENABLED', true));
        $acts = array_merge($acts, $this->getNeoQuery()->getActivityByUser($user, 'DISABLED', true));

        return $this->rest($acts);
    }
}