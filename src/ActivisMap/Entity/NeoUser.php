<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 28/06/16
 * Time: 18:35
 */

namespace ActivisMap\Entity;

use ActivisMap\Base\BaseEntity;
use HireVoice\Neo4j\Annotation as OGM;
use HireVoice\Neo4j\Extension\ArrayCollection;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class NeoUser
 * @package AppBundle\Entity
 * @OGM\Entity(labels="User")
 */
class NeoUser extends BaseEntity {

    /**
     * @OGM\Property(format="string")
     * @var string
     */
    protected $username;

    /**
     * @OGM\Property(format="string")
     * @var string
     */
    protected $personName;

    /**
     * @OGM\Property(format="string")
     * @var string
     */
    protected $email;

    /**
     * @OGM\Property(format="string")
     * @var string
     */
    protected $salt;

    /**
     * @OGM\Property(format="string")
     * @var string
     */
    protected $password;


    /**
     * @OGM\ManyToOne(relation="REGISTERED_IN")
     * @var Application
     */
    protected $application;

    /**
     * @OGM\Property(format="string")
     * @var string
     */
    protected $avatar;

    public function __construct() {
        parent::__construct('Usr');
        $this->avatar = 'https://' . $_SERVER['HTTP_HOST'] . '/avatar_m.png';

    }

    /**
     * @param $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }


    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        if ($this->personName == null) {
            $this->setPersonName($username);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
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
     * @return self
     */
    public function setPersonName($personName)
    {
        $this->personName = $personName;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
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
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
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
            'username' => $this->getUsername(),
            'personName' => $this->getPersonName(),
            'email' => $this->getEmail(),
            'avatar' => $this->getAvatar(),
        );

        return $view;
    }

    /**
     * @return array
     */
    public function getExtendView() {
        $view = $this->getBaseView();
        $view['password'] = $this->getPassword();
        $view['salt'] = $this->getSalt();

        return $view;
    }

    public function prepare()
    {
        $this->callGetters();
    }
}