<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 9/03/16
 * Time: 21:12
 */

namespace ActivisMap\Util;


use AppBundle\Entity\Device;
use AppBundle\Entity\Group;
use AppBundle\Entity\Message;
use AppBundle\Entity\NeoUser;
use AppBundle\Entity\Offer;
use AppBundle\Entity\Thread;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GCMSender {

    public static $API_KEY = 'AIzaSyCaL72zg7HSZeMZVkoM6UnXlgmFdIvnZtE';
    private static $SENDER_ID = '1073957975384';
    private static $GROUP_TOKEN_URL = 'https://android.googleapis.com/gcm/notification';
    private static $SEND_MESSAGE_URL = 'https://fcm.googleapis.com/fcm/send';

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }


    /**
     * @param string $url
     * @param array $params
     * @return array
     */
    private function send($url, $params) {


        $params = json_encode($params);
        $headers = array(
            'Authorization: key=' . GCMSender::$API_KEY,
            'Content-Type: application/json',
            'project_id: ' . GCMSender::$SENDER_ID
        );

        // create curl resource
        $ch = curl_init();
        // set url
        curl_setopt($ch, CURLOPT_URL, $url);
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$params);
        curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
        // $output contains the output string

/*        //Proxy
        curl_setopt($ch, CURLOPT_PROXY, "10.229.1.66:3128");
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "tico.nos:162011");*/

        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);

        $response = get_object_vars(json_decode($output));
/*        $response = json_decode($response, true);*/

        return $response;
    }

    /**
     * @param NeoUser $neoUser
     * @return array
     */
    public function createDeviceGroup(NeoUser $neoUser) {

        $user = $this->getUserByNeoId($neoUser->getId());

        $devices = $user->getDevices();
        $ids = array();
        foreach ($devices as $d) {
            $ids[] = $d->getGcmToken();
        }
        $params = array(
            'operation' => 'create',
            'notification_key_name' => $neoUser->getIdentifier(),
            'registration_ids' => $ids
        );

        $response = $this->send(self::$GROUP_TOKEN_URL, $params);
        return $response;
    }

    /**
     * @param NeoUser $neoUser
     * @param Device $device
     * @return array
     */
    public function addDeviceToGroup(NeoUser $neoUser, Device $device){

        $user = $this->getUserByNeoId($neoUser->getId());

        $params = array(
            'operation' => 'add',
            'notification_key_name' => $neoUser->getIdentifier(),
            'notification_key' => $user->getGroupToken(),
            'registration_ids' => array($device->getGcmToken())
        );

        $response = $this->send(self::$GROUP_TOKEN_URL, $params);
        return $response;
    }

    /**
     * @param NeoUser $neoUser
     * @param Device $device
     * @return array
     */
    public function removeDeviceToGroup(NeoUser $neoUser, Device $device){

        $user = $this->getUserByNeoId($neoUser->getId());

        $params = array(
            'operation' => 'remove',
            'notification_key_name' => $neoUser->getIdentifier(),
            'notification_key' => $user->getGroupToken(),
            'registration_ids' => array($device->getGcmToken())
        );

        $response = $this->send(self::$GROUP_TOKEN_URL, $params);
        return $response;
    }

    /**
     * @param Message $message
     * @return array
     */
    public function notifyMessage(Message $message) {

        $params = array(
            'to'  => '/topics/' . $message->getDestiny()->getIdentifier(),
            'data'  =>  array('message' => $message->getGCMView())
        );

        $response = $this->send(self::$SEND_MESSAGE_URL, $params);
        if (array_key_exists('error', $response)) {
            throw new HttpException(400, 'GCM ADDMESSAGE ERROR: ' . $response['error']);
        }
        return $response;
    }

    /**
     * @param Offer $offer
     * @return array
     */
    public function notifyOffer(Offer $offer) {

        $params = array(
            'to'  => '/topics/' . $offer->getThread()->getSender()->getIdentifier(),
            'data'  =>  array('message' => $offer->getGCMView())
        );

        $response = $this->send(self::$SEND_MESSAGE_URL, $params);
        if (array_key_exists('error', $response)) {
            throw new HttpException(400, 'GCM NOTIFY OFFER ERROR: ' . $response['error']);
        }
        return $response;
    }

    /**
     * @param Thread $thread
     * @return array
     */
    public function notifyAddThread(Thread $thread) {

        $groups = $thread->getDestinyGroups()->toArray();
        $responses = array();

        /** @var Group $g */
        foreach ($groups as $g) {
            $params = array(
                'to' => '/topics/' . $g->getIdentifier(),
                'data' => array('message' => $thread->getGCMView())
            );

            $responses[] = $this->send(self::$SEND_MESSAGE_URL, $params);
        }

        return $responses;
    }

    /**
     * @param Thread $thread
     * @return array
     */
    public function notifyAssignThread(Thread $thread) {

        $params = array(
            'to' => '/topics/App57a9d09f394de',
            'data' => array('message' => $thread->getGCMView())
        );

        $response = $this->send(self::$SEND_MESSAGE_URL, $params);

        return $response;
    }

    /**
     * @param Thread $thread
     * @return array
     */
    public function notifyForwardThread(Thread $thread) {

        $params = array(
            'to' => '/topics/' . $thread->getIdentifier(),
            'data' => array('message' => $thread->getGCMView())
        );

        $response = $this->send(self::$SEND_MESSAGE_URL, $params);

        return $response;
    }

    public function notifyNewGroup(Group $group) {
        $params = array(
            'to' => '/topics/App578fb139ca375',
            'data' => array('message' => $group->getGCMView())
        );

        $response = $this->send(self::$SEND_MESSAGE_URL, $params);

        return $response;
    }


    /**
     * @param integer $id
     * @return User
     */
    protected function getUserByNeoId($id) {
        $user = $this->manager
            ->getRepository('AppBundle:User')->findBy(array('neoId' => $id));

        if ($user == null) {
            throw new HttpException(404, 'User with neoId ' . $id . ' not found');
        }

        return $user[0];
    }


}