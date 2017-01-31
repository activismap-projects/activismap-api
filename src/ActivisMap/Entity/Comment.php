<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 31/01/17
 * Time: 12:13
 */

namespace ActivisMap\Entity;

use ActivisMap\Base\BaseEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Comment
 * @package ActivisMap\Entity
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="comment")
 */
class Comment extends BaseEntity {

    /**
     * @ORM\ManyToOne(targetEntity="ActivisMap\Entity\Event", inversedBy="comments")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     * @var Event
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="ActivisMap\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $comment;

    public function __construct(){
        parent::__construct('R');
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param Event $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setLastUpdate() {
        parent::setLastUpdate();
    }

    /**
     * @return array
     */
    public function getBaseView() {
        $view = array(
            'id' => $this->getId(),
            'created' => $this->getCreated(),
            'last_update' => $this->getLastUpdate(),
            'identifier' => $this->getIdentifier(),
            'comment' => $this->getComment(),
            'event' => $this->getEvent()->getBaseView()
        );

        $user = $this->getUser();

        if ($user != null) {
            $view['user'] = $user->getBaseView();
        }

        return $view;
    }
}