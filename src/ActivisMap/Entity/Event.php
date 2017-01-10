<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 22/09/16
 * Time: 23:30
 */

namespace ActivisMap\Entity;

use ActivisMap\Base\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Activity
 * @package ActivisMap\Entity
 * @ORM\Entity
 * @ORM\Table(name="event")
 */
class Event extends BaseEntity {

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $latitude;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $longitude;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $startDate;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $endDate;

    /**
     * @ORM\ManyToOne(targetEntity="ActivisMap\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var User
     */
    protected $creator;

    /**
     * @ORM\ManyToOne(targetEntity="ActivisMap\Entity\Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * @var Company
     */
    protected $company;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $status;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $categories;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $type;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $description;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $image;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    protected $participants;

    /**ñ
     * @ORM\Column(type="integer")
     * @var integer
     */
    protected $likes;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    protected $dislikes;

    /**
     * @ORM\ManyToMany(targetEntity="ActivisMap\Entity\User", inversedBy="managed_events")
     * @ORM\JoinTable(name="managers_events")
     * @var ArrayCollection
     */
    protected $managers;

    public function __construct() {
        parent::__construct('E');
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
        return $this->startDate;
    }

    /**
     * @param int $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return int
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param int $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return User
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param User $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param Company $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
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
     * @return integer
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @param integer $participants
     */
    public function setParticipants($participants)
    {
        $this->participants = $participants;
    }

    public function incrementParticipants() {
        $this->participants++;
    }

    public function decrementParticipants() {
        if ($this->participants > 1) {
            $this->participants--;
        }
    }

    /**
     * @return integer
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param integer $likes
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
    }

    public function like() {
        $this->likes++;
    }

    public function removeLike() {
        if ($this->likes > 1) {
            $this->likes--;
        }
    }

    /**
     * @return integer
     */
    public function getDislikes()
    {
        return $this->dislikes;
    }

    /**
     * @param integer $dislikes
     */
    public function setDislikes($dislikes)
    {
        $this->dislikes = $dislikes;
    }

    public function dislike() {
        $this->dislikes++;
    }

    public function removeDislike() {
        if ($this->dislikes > 1) {
            $this->dislikes--;
        }
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
     * @param User $user
     */
    public function addManager(User $user) {
        $this->managers->add($user);
    }

    /**
     * @param User $user
     */
    public function removeManager(User $user) {
        $this->managers->removeElement($user);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isManager(User $user) {
        return $this->managers->contains($user);
    }

    /**
     * @return array
     */
    public function getBaseView() {
        $view = array(
            'id' => $this->getId(),
            'created' => $this->getCreated(),
            'last_update' => $this->getLastUpdate(),
            'identifier' => $this->getIdentifier(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'image' => $this->getImage(),
            'status' => $this->getStatus(),
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude(),
            'start_date' => $this->getStartDate(),
            'end_date' => $this->getEndDate(),
            'categories' => $this->getCategories(),
            'type' => $this->getType(),
            'participants' => $this->getParticipants(),
            'likes' => $this->getLikes(),
            'dislikes' => $this->getDislikes(),
            'creator' => $this->getCreator()->getBaseView(),
            'company' => $this->getCompany()->getBaseView()
        );

        $mans = $this->getManagers();
        $mViews = array();
        /** @var User $m */
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
        return $view;
    }
}