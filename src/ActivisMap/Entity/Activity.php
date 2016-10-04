<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 22/09/16
 * Time: 23:30
 */

namespace ActivisMap\Entity;

use ActivisMap\Base\BaseEntity;
use HireVoice\Neo4j\Annotation as OGM;
use HireVoice\Neo4j\Extension\ArrayCollection;

/**
 * Class Activity
 * @package ActivisMap\Entity
 * @OGM\Entity(labels="Activity")
 */
class Activity extends BaseEntity {

    /**
     * @OGM\Property(format="double")
     * @var float
     */
    protected $latitude;

    /**
     * @OGM\Property(format="double")
     * @var float
     */
    protected $longitude;

    /**
     * @var integer
     * @OGM\Property(format="integer")
     */
    protected $start_date;

    /**
     * @var integer
     * @OGM\Property(format="integer")
     */
    protected $end_date;

    /**
     * @OGM\ManyToOne(relation="CREATED_BY")
     * @var NeoUser
     */
    protected $creator;

    /**
     * @OGM\Property(format="string")
     * @var string
     */
    protected $status;

    /**
     * @OGM\Property(format="string")
     * @var string
     */
    protected $categories;

    /**
     * @OGM\Property(format="string")
     * @var string
     */
    protected $type;

    /**
     * @OGM\Property(format="string")
     * @var string
     */
    protected $title;

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

    /**
     * @OGM\Property(format="integer")
     * @var string
     */
    protected $participants;

    /**
     * @OGM\Property(format="integer")
     * @var string
     */
    protected $likes;

    /**
     * @OGM\Property(format="integer")
     * @var string
     */
    protected $dislikes;

    /**
     * @OGM\ManyToMany(relation="MANAGED_BY")
     * @var ArrayCollection
     */
    protected $managers;

    /**
     * @OGM\ManyToOne(relation="CREATED_IN")
     * @var Application
     */
    protected $application;

    public function __construct() {
        parent::__construct('Act');
        $this->managers = new ArrayCollection();
        $this->status = 'WORKING';
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return int
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @param int $start_date
     */
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }

    /**
     * @return int
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * @param int $end_date
     */
    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
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
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param string $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     * @return string
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @param string $participants
     */
    public function setParticipants($participants)
    {
        $this->participants = $participants;
    }

    /**
     * @return string
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param string $likes
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
    }

    /**
     * @return string
     */
    public function getDislikes()
    {
        return $this->dislikes;
    }

    /**
     * @param string $dislikes
     */
    public function setDislikes($dislikes)
    {
        $this->dislikes = $dislikes;
    }

    /**
     * @return ArrayCollection
     */
    public function getManagers()
    {
        return $this->managers;
    }

    /**
     * @param ArrayCollection $managers
     */
    public function setManagers($managers)
    {
        $this->managers = $managers;
    }

    /**
     * @param NeoUser $user
     */
    public function addManager(NeoUser $user) {
        $this->managers->add($user);
    }

    /**
     * @param NeoUser $user
     */
    public function removeManager(NeoUser $user) {
        $this->managers->removeElement($user);
    }

    /**
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param Application $application
     */
    public function setApplication($application)
    {
        $this->application = $application;
    }

    /**
     * @param NeoUser $user
     * @return bool
     */
    public function isManager(NeoUser $user) {
        return $this->managers->contains($user);
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
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'image' => $this->getImage(),
            'status' => $this->getStatus(),
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude(),
            'startDate' => $this->getStartDate(),
            'duration' => $this->getEndDate(),
            'categories' => $this->getCategories(),
            'type' => $this->getType(),
            'participants' => $this->getParticipants(),
            'likes' => $this->getLikes(),
            'dislikes' => $this->getDislikes(),
            'creator' => $this->getCreator()->getBaseView(),
        );

        $mans = $this->getManagers();
        $mViews = array();
        /** @var NeoUser $m */
        foreach($mans as $m) {
            $mViews[] = $m->getBaseView();
        }

        $view['managers'] = $mViews;

        return $view;
    }

    /**
     * @return array
     */
    public function getExtendView() {
        $view = $this->getBaseView();
        $view['application'] = $this->getApplication()->getBaseView();
        return $view;
    }

    public function prepare() {
        $this->callGetters();
    }
}