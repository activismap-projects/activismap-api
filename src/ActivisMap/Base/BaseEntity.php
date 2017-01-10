<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 22/06/16
 * Time: 18:36
 */

namespace ActivisMap\Base;
use ActivisMap\Util\EntityUtils;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class BaseEntity
 * @package ActivisMap\Base
 * @ORM\HasLifecycleCallbacks
 */
abstract class BaseEntity {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $identifier;

    /**
     * @var integer
     * @ORM\Column(type=="integer")
     */
    protected $created;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $lastUpdate;

    /**
     * @Orm\Column(type="boolean")
     * @var bool
     */
    protected $enabled;

    /**
     * @param string $prefix
     */
    public function __construct($prefix) {
        $this->created = EntityUtils::millis();
        $this->identifier = uniqid($prefix);
    }

    /**
     * @return int
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return int
     */
    public function getLastUpdate() {
        if ($this->lastUpdate == null || $this->lastUpdate == 0) {
            return $this->getCreated();
        }
        return $this->lastUpdate;
    }

    /**
     * @ORM\PrePersist
     */
    public function setLastUpdate()
    {
        $this->lastUpdate = EntityUtils::millis();
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}