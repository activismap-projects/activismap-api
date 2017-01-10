<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 9/01/17
 * Time: 20:53
 */

namespace ActivisMap\Base;

use ActivisMap\Util\EntityUtils;
use FOS\UserBundle\Model\User as DOCUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class BaseUser
 * @package ActivisMap\Base
 * @ORM\HasLifecycleCallbacks
 */
class BaseUser extends DOCUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected $identifier;

    /**
     * @ORM\Column(type="bigint")
     * @var int
     */
    protected $created;

    /**
     * @ORM\Column(type="bigint")
     * @var int
     */
    protected $lastUpdate;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $personName;

    public function __construct() {
        parent::__construct();
        $this->created = EntityUtils::millis();
        $this->identifier = uniqid("", true);
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
     * @return int
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param int $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return int
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * @ORM\PrePersist
     * @return int
     */
    public function setLastUpdate()
    {
        if ($this->lastUpdate == null || $this->lastUpdate == 0) {
            return $this->getCreated();
        }
        return $this->lastUpdate;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}