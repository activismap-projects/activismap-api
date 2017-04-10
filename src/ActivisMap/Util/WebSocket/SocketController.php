<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 12/12/16
 * Time: 22:35
 */

namespace ActivisMap\Util\WebSocket;

use ActivisMap\Base\BaseEntity;
use ActivisMap\Entity\AccessToken;
use ActivisMap\Entity\User;
use ActivisMap\Error\ApiError;
use ActivisMap\Error\ApiException;
use ActivisMap\Util\GCMSender;
use Doctrine\ORM\EntityRepository;
use Gos\Bundle\WebSocketBundle\DataCollector\PusherDecorator;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManager as DocManager;

class SocketController{

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var DocManager
     */
    protected $entityManager;

    /**
     * @var PusherDecorator
     */
    protected $pusher;

    /**
     * @param $docManager
     * @param $pusher
     */
    public function __construct($docManager, $pusher) {
        $this->logger = new Logger('socket-topic');
        $this->entityManager = $docManager;
        $this->pusher = $pusher;
    }

    /**
     * @return PusherDecorator
     */
    public function getPusher()
    {
        return $this->pusher;
    }

    /**
     * @return DocManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }


    /**
     * @param $event
     * @return User
     */
    protected function getUser($event) {

        if (is_array($event)) {
            $token = $event['access_token'];
        } else {
            $token = $event;
        }

        $accessToken = $this->entityManager->getRepository('AppBundle:AccessToken')
            ->findBy(array('token' => $token));

        if (count($accessToken) > 0) {
            $accessToken = $accessToken[0];
        } else {
            $accessToken = null;
        }
        /** @var AccessToken $accessToken */
        if ($accessToken == null || $accessToken->hasExpired()) {
            return null;
        }

        return $accessToken->getUser();
    }

    /**
     * @return EntityRepository
     */
    public function getUserRepository() {
        return $this->getEntityManager()->getRepository('ActivisMap:User');
    }

    /**
     * @return EntityRepository
     */
    public function getEventRepository() {
        return $this->getEntityManager()->getRepository('ActivisMap:Event');
    }

    /**
     * @return EntityRepository
     */
    public function getCompanyRepository() {
        return $this->getEntityManager()->getRepository('ActivisMap:Company');
    }

    /**
     * @return EntityRepository
     */
    public function getCompanyRolesRepository() {
        return $this->getEntityManager()->getRepository('ActivisMap:UserCompany');
    }

    /**
     * @return EntityRepository
     */
    public function getCommentRepository() {
        return $this->getEntityManager()->getRepository('ActivisMap:Comment');
    }

    /**
     * @param string $type
     * @param int|string $id
     * @return array
     */
    public function getDestination($type, $id) {
        return array(
            'type' => $type,
            'id' => $id
        );
    }

    /**
     * @param $msg
     * @param bool|false $error
     * @return array
     */
    public function getData($msg, $error = false) {
        return array(
            'error' => $error,
            'notification' => $msg
        );
    }

    /**
     * @param array $data
     * @param array $to
     */
    public function notify($data, $to) {
        $this->getPusher()
            ->push($data, 'thread_socket', $to);
    }
}