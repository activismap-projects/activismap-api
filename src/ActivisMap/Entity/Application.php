<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 11/07/16
 * Time: 22:03
 */

namespace ActivisMap\Entity;

use ActivisMap\Base\BaseEntity;
use HireVoice\Neo4j\Annotation as OGM;
use HireVoice\Neo4j\Extension\ArrayCollection;

/**
 * Class Application
 * @package AppBundle\Entity
 * @OGM\Entity(labels="Application")
 */
class Application extends BaseEntity {


    /**
     * @OGM\Property(format="string")
     * @var string
     */
    protected $name;

    public function  __construct() {
        parent::__construct('App');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getBaseView() {
        return array(
            'id' => $this->getId(),
            'identifier' => $this->getIdentifier(),
            'created' => $this->getCreated(),
            'updated' => $this->getLastUpdate(),
            'name' => $this->getName()
        );
    }


    public function prepare()
    {
        $this->callGetters();
    }
}