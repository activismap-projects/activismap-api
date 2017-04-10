<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 12/12/16
 * Time: 21:24
 */

namespace AppBundle\Util\WebSocket;


use Doctrine\ORM\EntityManager;
use Gos\Bundle\WebSocketBundle\Event\ClientErrorEvent;
use Gos\Bundle\WebSocketBundle\Event\ClientEvent;
use Gos\Bundle\WebSocketBundle\Event\ClientRejectedEvent;
use Gos\Bundle\WebSocketBundle\Event\ServerEvent;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class ClientListener {

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * ClientListener constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->logger = new Logger('clientListener');
    }


    /**
     * @param ClientEvent $event
     */
    public function onClientConnect(ClientEvent $event)
    {
        $conn = $event->getConnection();

        $this->logger->alert('OnConnect', array($conn->resourceId));
    }

    /**
     * @param ClientEvent $event
     */
    public function onClientDisconnect(ClientEvent $event)
    {
        $conn = $event->getConnection();

        $this->logger->alert('OnDisConnect', array($conn->resourceId));
    }

    /**
     * @param ClientErrorEvent $event
     */
    public function onClientError(ClientErrorEvent $event)
    {
        $conn = $event->getConnection();
        $e = $event->getException();

        $this->logger->alert('OnError', array($conn->resourceId));
    }

    /**
     * @param ServerEvent $event
     */
    public function onServerStart(ServerEvent $event)
    {
        $event = $event->getEventLoop();

        echo 'Server was successfully started !'. PHP_EOL;
    }


    /**
     * @param ClientRejectedEvent $event
     */
    public function onClientRejected(ClientRejectedEvent $event)
    {
        $origin = $event->getOrigin;

        echo 'connection rejected from '. $origin . PHP_EOL;
    }

}