<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 9/01/17
 * Time: 20:57
 */

namespace ActivisMap\Base;

use ActivisMap\Util\EntityUtils;
use FOS\UserBundle\Model\Group as DOCGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class BaseGroup
 * @package ActivisMap\Base
 * @ORM\HasLifecycleCallbacks
 */
class BaseGroup extends DOCGroup {

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
     * @param string $name
     * @param array $roles
     */
    public function __construct($name, $roles = array()) {
        parent::__construct($name, $roles);
        $this->created = EntityUtils::millis();
        $this->identifier = uniqid("", true);
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