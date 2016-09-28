<?php
// src/ActivisMap/Entity/User.php

namespace ActivisMap\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $personName;

    /**
     * @ORM\Column(type="integer", nullable=false, unique=true)
     */
    protected $neoId;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @return string
     */
    public function getPersonName()
    {
        return $this->personName;
    }

    /**
     * @param string $personName
     */
    public function setPersonName($personName)
    {
        $this->personName = $personName;
    }

    /**
     * @return mixed
     */
    public function getNeoId()
    {
        return $this->neoId;
    }

    /**
     * @param int $neoId
     */
    public function setNeoId($neoId)
    {
        $this->neoId = $neoId;
    }

    /**
     * @param NeoUser $neoUser
     * @return NeoUser
     */
    public function toNeoUser(NeoUser $neoUser = null) {

        if ($neoUser == null) {
            $neoUser = new NeoUser();
        }

        $password = $this->getPlainPassword();
        $salt = $this->getSalt();
        $salted = $password.'{'.$salt.'}';
        $digest = hash('sha512', $salted, true);

        for ($i=1; $i<5000; $i++) {
            $digest = hash('sha512', $digest.$salted, true);
        }

        $encodedPassword = base_convert($digest, 16, 32);

        $neoUser->setPassword($encodedPassword);
        $neoUser->setSalt($this->getSalt());
        $neoUser->setUsername($this->getUsername());
        $neoUser->setPersonName($this->getPersonName());
        $neoUser->setEmail($this->getEmail());
        return $neoUser;
    }
}
