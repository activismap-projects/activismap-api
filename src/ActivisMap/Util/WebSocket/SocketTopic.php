<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 12/12/16
 * Time: 16:23
 */

namespace ActivisMap\Util\WebSocket;

use ActivisMap\Error\ApiError;
use Gos\Bundle\WebSocketBundle\Router\WampRequest;
use Gos\Bundle\WebSocketBundle\RPC\RpcInterface;
use Gos\Bundle\WebSocketBundle\Topic\PushableTopicInterface;
use Gos\Bundle\WebSocketBundle\Topic\TopicInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\Topic;

class SocketTopic extends SocketController implements TopicInterface, PushableTopicInterface, RpcInterface {

    /**
     * SocketTopic constructor.
     * @param $docManager
     * @param $pusher
     */
    public function __construct($docManager, $pusher) {
        parent::__construct($docManager, $pusher);
    }

    /**
     * @param Topic $topic
     * @param WampRequest $request
     * @param string|array $data
     * @param string $provider
     */
    public function onPush(Topic $topic, WampRequest $request, $data, $provider) {
        $this->logger->debug($topic->getId(), array($data));
        $topic->broadcast($data);
    }

    /**
     * @param  ConnectionInterface $connection
     * @param  Topic $topic
     * @param WampRequest $request
     */
    public function onSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)  {
        $params = $request->getAttributes()->all();
        $this->logger->error('params', $params);
    }

    /**
     * @param  ConnectionInterface $connection
     * @param  Topic $topic
     * @param WampRequest $request
     */
    public function onUnSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {

    }

    /**
     * @param ConnectionInterface $connection
     * @param Topic $topic
     * @param WampRequest $request
     * @param $event
     * @param array $exclude
     * @param array $eligible
     */
    public function onPublish(ConnectionInterface $connection, Topic $topic, WampRequest $request, $event, array $exclude, array $eligible)
    {
        //$event = json_decode($event, true);
        $this->logger->error('New message on ', array($topic->getId()));
        $this->logger->error('received', array($event));

        if ($this->entityManager->getConnection()->ping() === false) {
            $this->entityManager->getConnection()->close();
            $this->entityManager->getConnection()->connect();
        }

        $user = $this->getUser($event);
        if ($user == null) {
            $error = $this->getData(ApiError::USER_NOT_FOUND, true);
            $connection->send($error);
            //$connection->close();
        } else {
            $this->router($connection, $user, $topic, $event);
        }


    }

    /**
     * @param ConnectionInterface $conn
     * @param $user
     * @param Topic $topic
     * @param $data
     */
    private function router(ConnectionInterface $conn, $user, Topic $topic, $data) {
        $t = explode('/', $topic->getId());
        $tId = $t[2];
        $content = $data['content'];
        switch($tId) {
            case 'send':
                $thread = $this->getThread($content['thread_id']);
                $this->sendMessage($conn, $user, $thread, $content);
                break;
            case 'received':
                $mess = $this->getMessage($content['message_id']);
                $this->receivedMessage($conn, $user, $mess, $content);
                break;
            case 'seen':
                $mess = $this->getMessage($content['message_id']);
                $this->seenMessage($conn, $user, $mess, $content);
                break;
        }
    }

    /**
     * @param ConnectionInterface $conn
     * @param NeoUser $senderUser
     * @param Message $message
     * @param array $data
     */
    private function receivedMessage(ConnectionInterface $conn, $senderUser, $message, $data) {
        if ($message != null) {

            $to = $this->getDestination('thread', $message->getThread()->getIdentifier());
            $mess = $message->getWSView();
            $mess['status'] = 'RECEIVED';
            $data = $this->getData($mess, false);
            $this->notify($data, $to);
            $conn->send(json_encode($data));
            $this->getGCMSender()->notifyMessage($mess);
        } else {
            $to = $this->getDestination('user', $senderUser->getIdentifier());
            $this->notify($this->getData(ApiError::MESSAGE_NOT_FOUND, true), $to);
            $conn->send(json_encode($this->getData(ApiError::MESSAGE_NOT_FOUND, true)));

        }

    }

    /**
     * @param ConnectionInterface $conn
     * @param NeoUser $senderUser
     * @param Message $message
     * @param array $data
     */
    private function seenMessage(ConnectionInterface $conn, $senderUser, $message, $data) {
        if ($message != null) {
            $to = 'user/'. $message->getSender()->getIdentifier();
            $mess = $message->getWSView();
            $mess['status'] = 'SEEN';
            $this->notify($mess, $to);
        } else {
            $to = $this->getDestination('user', $senderUser->getIdentifier());
            $this->notify($this->getData(ApiError::MESSAGE_NOT_FOUND, true), $to);
            $conn->send(json_encode($this->getData(ApiError::MESSAGE_NOT_FOUND, true)));


        }
    }

    /**
     * @param ConnectionInterface $conn
     * @param NeoUser $senderUser
     * @param Thread $thread
     * @param array $data
     */
    private function sendMessage(ConnectionInterface $conn, $senderUser, $thread, $data) {
        if ($thread != null) {
            if ($thread->checkAccess($senderUser)) {
                $mess = new Message();
                //Comprobamos quien es el usuario de destino, si el thread está
                //en estado new o forwarded entonces solo un trabajador podrá enviar mensajes
                //si el estado es assigned solo el creador y el assigned podran enviar mensajes
                //si es closed, ninguno podra enviar mensajes

                if ($thread->enabledToSendMessages($senderUser)) {
                    if ($thread->isAssigned()) {
                        if ($thread->getAssignedUser()->getId() == $senderUser->getId()) {
                            $destUser = $thread->getSender();
                        } else {
                            $destUser = $thread->getAssignedUser();
                        }

                        $mess->setDestiny($destUser);
                        $toDest = $this->getDestination('user', $destUser->getIdentifier());

                    } else {
                        $toDest = $this->getDestination('thread', $thread->getIdentifier());
                    }

                    $toSender = $this->getDestination('user', $senderUser->getIdentifier());
                    $mess->setSender($senderUser);
                    $mess->setContentType($data['content_type']);
                    $mess->setDestinyMessage($data['destiny_message']);
                    $mess->setMiddleMessage($data['middle_message']);
                    $mess->setSenderMessage(($data['sender_message']));
                    $mess->setMessageHash($data['message_hash']);
                    $mess->setThread($thread);

                    $this->saveInNeo($mess);

                    $this->notify($this->getData($mess->getWSView()), $toDest);
                    $this->notify($this->getData($mess->getWSView()), $toSender);
                    $gcmData = $this->getGCMSender()->notifyMessage($mess);
                    $this->logger->debug('GCM WS', $gcmData);
                } else {
                    //THREAD NO ALLOW NEW MESASGES
                    $toDest = $this->getDestination('user', $senderUser->getIdentifier());
                    $this->notify($this->getData(ApiError::MESSAGE_PERMISSION_DENIED, true), $toDest);
                    $conn->send(json_encode($this->getData(ApiError::MESSAGE_PERMISSION_DENIED, true)));
                }
            }  else {
                //NO ACCESS TO THREAD
                $toDest = $this->getDestination('user', $senderUser->getIdentifier());
                $this->notify($this->getData(ApiError::USER_CANNOT_INTERACT, true), $toDest);
                $conn->send(json_encode($this->getData(ApiError::USER_CANNOT_INTERACT, true)));

            }
        } else {
            $toDest = $this->getDestination('user', $senderUser->getIdentifier());
            $this->notify($this->getData(ApiError::THREAD_NOT_FOUND, true), $toDest);
            $conn->send(json_encode($this->getData(ApiError::THREAD_NOT_FOUND, true)));

        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'thread.socket';
    }
}