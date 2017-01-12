<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 9/01/17
 * Time: 21:28
 */

namespace ActivisMap\Entity;


use ActivisMap\Base\BaseGroup;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Company
 * @package ActivisMap\Entity
 * @ORM\Entity
 * @ORM\Table("company")
 * @ORM\HasLifecycleCallbacks
 */
class Company extends BaseGroup {

    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $logo;

    /**
     * @ORM\OneToMany(targetEntity="ActivisMap\Entity\UserCompany", mappedBy="company", cascade={"remove"})
     * @var ArrayCollection
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="ActivisMap\Entity\Event", mappedBy="company")
     * @var ArrayCollection
     */
    protected $events;

    public function __construct($name) {
        parent::__construct($name);
        $this->users = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param User $user
     * @return UserCompany
     */
    public function getUserRoles(User $user ) {
        $users = $this->getUsers();

        /** @var UserCompany $u */
        foreach ($users as $u) {
            if ($u->getUser()->getId() == $user->getId()) {
                return $u;
            }
        }

        $role = new UserCompany();
        $role->setUser($user);
        $role->setCompany($this);
        return $role;
    }

    /**
     * @return ArrayCollection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
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
        return array(
            'id' => $this->getId(),
            'identifier' => $this->getIdentifier(),
            'created' => $this->getCreated(),
            'last_update' => $this->getLastUpdate(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'logo' => $this->getLogo()
        );
    }

    /**
     * @return array
     */
    public function getExtendView() {
        $view = $this->getBaseView();

        $usersView = array();

        $users = $this->getUsers();

        /** @var UserCompany $u */
        foreach ($users as $u) {
            $usersView[] = $u->getCompanyView();
        }

        $eventsView = array();

        $events = $this->getEvents();

        /** @var Event $e */
        foreach ($events as $e) {
            $eventsView[] = $e->getBaseView();
        }

        $view['users'] = $usersView;
        $view['events'] = $eventsView;

        return $view;
    }

}