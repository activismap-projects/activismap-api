<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 22/09/16
 * Time: 23:45
 */

namespace ActivisMap\Entity;

use ActivisMap\Base\BaseEntity;
use HireVoice\Neo4j\Annotation as OGM;

/**
 * Class Alert
 * @package ActivisMap\Entity
 * @OGM\Entity(labels="Alert")
 */
class Alert extends BaseEntity {

    /**
     * @OGM\ManyToOne(relation="CREATED_BY")
     * @var NeoUser
     */
    protected $creator;

    /**
     * @OGM\ManyToOne(relation="ATTACHED_TO")
     * @var Activity
     */
    protected $activity;

    /**
     * @var integer
     * @OGM\Property(format="integer")
     */
    protected $publish_date;

    /**
     * @OGM\Property(format="string")
     * @var string
     */
    protected $status;

    /**
     * @OGM\Property(format="string")
     * @var string
     */
    protected $description;

    /**
     * @OGM\Property(format="string")
     * @var string
     */
    protected $image;

    public function __construct() {
        parent::__construct('Alt');
        $this->status = 'PENDING';
    }

    /**
     * @return NeoUser
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param NeoUser $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    /**
     * @return Activity
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @param Activity $activity
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;
    }

    /**
     * @return int
     */
    public function getPublishDate()
    {
        return $this->publish_date;
    }

    /**
     * @param int $publish_date
     */
    public function setPublishDate($publish_date)
    {
        $this->publish_date = $publish_date;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return array
     */
    public function getBaseView() {
        $view = array(
            'id' => $this->getId(),
            'created' => $this->getCreated(),
            'updated' => $this->getLastUpdate(),
            'identifier' => $this->getIdentifier(),
            'description' => $this->getDescription(),
            'image' => $this->getImage(),
            'status' => $this->getStatus(),
            'publishDate' => $this->getPublishDate(),
            'creator' => $this->getCreator()->getBaseView(),
        );

        return $view;
    }

    public function prepare() {
        $this->callGetters();
    }
}