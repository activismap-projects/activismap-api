<?php
// src/ActivisMap/Entity/User.php

namespace ActivisMap\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
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
}
