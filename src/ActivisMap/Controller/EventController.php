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
use ActivisMap\Util\Roles;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ActivityController
 * @package ActivisMap\Controller
 * @Route("/v1/event")
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
            'title', 'description', 'start_date', 'categories', 'type', 'lat', 'lon', 'end_date', 'company_id'));

        $identifier = $params['company_id'];
        $company = $this->getCompany($identifier);

        $userRoles = $company->getUserRoles($user);
        if (!$userRoles->isGrantedFor(Roles::ROLE_SUPER_ADMIN)) {
            throw new HttpException(401, 'You do not have necessary permissions');
        }

        $event = new Event();
        $event->setTitle($params['title']);
        $event->setDescription($params['description']);
        $event->setCategories($params['categories']);
        $event->setType($params['type']);
        $event->setCreator($user);
        $event->setStartDate(intval($params['start_date']));
        $event->setLatitude(floatval($params['lat']));
        $event->setLongitude(floatval($params['lon']));
        $event->setEndDate(intval($params['end_date']));
        $event->setCompany($company);

        $this->setImage($request, 'image', $event);

        $this->save($event);

        return $this->rest($event->getExtendView());
    }

    /**
     * @Route("/{identifier}")
     * @Method("PUT")
     * @param Request $request
     * @param $identifier
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateEvent(Request $request, $identifier) {
        $event = $this->getEvent($identifier);
        $user = $this->getUser();

        if (!$event->isManager($user)) {
            throw new HttpException(401, 'You do not have necessary permissions');
        }

        $company = $event->getCompany();
        $userRoles = $company->getUserRoles($user);

        if ($userRoles->isGrantedFor(Roles::ROLE_PUBLISHER)) {
            $request->request->remove('managers');
        } else if ($request->request->has('managers')) {
            $reqManagers = $request->request->get('managers');
            $managers = new ArrayCollection();

            foreach ($reqManagers as $m) {
                $user = $this->getUser($m);
                $managers->add($user);
            }

            $request->request->set('managers', $managers);
        }

        /** @var Event $event */
        $event = parent::updateAction($request, $identifier);
        return $this->rest($event->getExtendView());
    }

    /**
     * @Route("/{identifier}")
     * @Method("DELETE")
     * @param Request $request
     * @param $identifier
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteEvent(Request $request, $identifier) {
        $user = $this->getUser();
        $event = $this->getEvent($identifier);
        $company = $event->getCompany();
        $userRole = $company->getUserRoles($user);

        if (!$userRole->isGrantedFor(Roles::ROLE_ADMIN)) {
            throw new HttpException(401, 'You do not have necessary permissions.');
        }

        return $this->deleteAction($event->getId());
    }

    protected function getRepositoryName()
    {
        return 'ActivisMap:Event';
    }
}