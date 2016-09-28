<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 22/06/16
 * Time: 18:36
 */

namespace ActivisMap\Base;
use ActivisMap\Util\EntityUtils;
use HireVoice\Neo4j\Annotation as OGM;

abstract class BaseEntity {
    /**
     * @OGM\Auto
     * @var integer
     */
    protected $neoId;

    /**
     * @OGM\Property(format="string")
     * @var string
     */
    protected $identifier;

    /**
     * @var integer
     * @OGM\Property(format="integer")
     */
    protected $created;

    /**
     * @var integer
     * @OGM\Property(format="integer")
     */
    protected $last_update;

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
        if ($this->last_update == null || $this->last_update == 0) {
            return $this->getCreated();
        }
        return $this->last_update;
    }

    public function setLastUpdate()
    {
        $this->last_update = EntityUtils::millis();
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return array
     */
    public function callGetters() {
        $getters = array();
        $methods = get_class_methods($this);

        foreach ($methods as $m) {
           if (strpos($m, 'get') === 0 && $m != 'getEntity') {
               $getters[] = $m;
           }
        }

        //die(print_r($getters, true));

        foreach ($getters as $get) {
            call_user_func_array(array($this, $get), array());
        }

        return $getters;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->neoId;
    }

    public abstract function prepare();
}