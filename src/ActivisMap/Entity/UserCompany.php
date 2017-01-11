<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 10/01/17
 * Time: 18:08
 */

namespace ActivisMap\Entity;

use Doctrine\ORM\Mapping as ORM;
use ActivisMap\Util\Roles;

/**
 * Class UserCompany
 * @package ActivisMap\Entity
 * @ORM\Entity
 * @ORM\Table(name="fos_user_company")
 */
class UserCompany {
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="ActivisMap\Entity\User")
     * @var User
     */
    private $user;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="ActivisMap\Entity\Company")
     * @var Company
     */
    private $company;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $roles;

    public function __construct() {
        $this->roles = '';
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
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
     * @return array
     */
    public function getRoles()
    {
        /** @var array $roles */
        $roles = unserialize($this->roles);

        return $roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = serialize($roles);
    }

    /**
     * @param array $roles
     */
    public function addRoles($roles) {
        foreach ($roles as $r) {
            $this->addRole($r);
        }
    }

    /**
     * @param string $role
     */
    public function addRole($role) {

        $roles = unserialize($this->getRoles());
        if (!in_array($role, $roles)) {
            $roles[] = $role;
        }

        $this->roles = serialize($roles);
    }

    /**
     * @param string $role
     */
    public function removeRole($role) {
        $roles = unserialize($this->getRoles());
        if ($key = array_search($role, $roles, true) !== false) {
            unset($roles[$key]);
        }

        $this->roles = serialize($roles);
    }

    /**
     * @param array $roles
     */
    public function removeRoles($roles) {
        foreach ($roles as $r) {
            $this->removeRole($r);
        }
    }

    /**
     * @param string $grant
     * @return bool
     */
    public function isGrantedFor($grant) {

        $grant = strtoupper($grant);
        switch($grant) {
            case Roles::ROLE_SUPER_ADMIN:
                return in_array($grant, $this->getRoles());
            case Roles::ROLE_ADMIN:
                return in_array(Roles::ROLE_SUPER_ADMIN, $this->getRoles()) ||  in_array($grant, $this->getRoles());
            default:
                return in_array(Roles::ROLE_SUPER_ADMIN, $this->getRoles()) ||  in_array(Roles::ROLE_ADMIN, $this->getRoles()) || in_array($grant, $this->getRoles());
        }
    }

    /**
     * @return null|string
     */
    public function getMaxRole() {
        return Roles::getMaxRole($this->getRoles());
    }

    /**
     * @return array
     */
    public function getUserView() {
        $view = $this->getCompany()->getBaseView();
        $view['roles'] = $this->getRoles();
        return $view;
    }

    /**
     * @return array
     */
    public function getCompanyView() {
        $view = $this->getUser()->getBaseView();
        $view['roles'] = $this->getRoles();
        return $view;
    }
}