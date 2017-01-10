<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 23/09/16
 * Time: 1:32
 */

namespace ActivisMap\Controller;

use ActivisMap\Base\EntityController;
use ActivisMap\Entity\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ActivityController
 * @package ActivisMap\Controller
 * @Route("/v1/activity")
 */
class EventController extends EntityController {

    /**
     * @Route("")
     * @Method("POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createEvent(Request $request) {
        $user = $this->getUser();

        $params = $this->checkParams($request, array(
            'title', 'description', 'start_date', 'categories', 'type', 'lat', 'lon', 'end_date'),
            array('image64', 'image_name'));

        $files = $this->checkFiles($request, array(), array('image'));

        $act = new Event();
        $act->setTitle($params['title']);
        $act->setDescription($params['description']);
        $act->setCategories($params['categories']);
        $act->setType($params['type']);
        $act->setCreator($user);
        $act->setStartDate(intval($params['start_date']));
        $act->setLatitude(floatval($params['lat']));
        $act->setLongitude(floatval($params['lon']));
        $act->setEndDate(intval($params['end_date']));

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

        $this->save($act);

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
        $act = $this->getEvent($actId);
        $user = $this->getUser();

        if (!$act->isManager($user)) {
            throw new HttpException(401, 'You do not have necessary permissions');
        }

        /** @var Event $act */
        $act = parent::updateAction($request, $actId);
        return $this->rest($act->getExtendView());
    }

    /**
     * @Route("/getManagedActivities")
     * @Method("GET")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getManagedActivities(Request $request) {
        $user = $this->getUser();

        $acts = $user->getManagedEvents()->toArray();

        $actsView = array();

        /** @var Event $e */
        foreach ($acts as $e) {
            $actsView[] = $e->getBaseView();
        }

        return $this->rest($acts);
    }

    protected function getRepositoryName()
    {
        return 'ActivisMap:Event';
    }
}