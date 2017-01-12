<?php
// src/ActivisMap/Entity/User.php

namespace ActivisMap\Entity;

use ActivisMap\Base\BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser {

    /**
     * @ORM\OneToMany(targetEntity="ActivisMap\Entity\UserCompany", mappedBy="user", cascade={"remove"})
     * @var ArrayCollection
     */
    protected $companies;

    /**
     * @ORM\OneToMany(targetEntity="ActivisMap\Entity\Event", mappedBy="creator")
     * @var ArrayCollection
     */
    protected $created_events;

    public function __construct() {
        parent::__construct();
        $this->created_events = new ArrayCollection();
        $this->companies = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getCompanies()
    {
        return $this->companies;
    }

    /**
     * @param ArrayCollection $companies
     */
    public function setCompanies($companies)
    {
        $this->companies = $companies;
    }

    /**
     * @param Company $company
     */
    public function addCompany(Company $company) {
        $this->companies->add($company);
    }

    /**
     * @param Company $company
     */
    public function removeCompany(Company $company) {
        $this->companies->remove($company);
    }

    /**
     * @return ArrayCollection
     */
    public function getCreatedEvents()
    {
        return $this->created_events;
    }

    /**
     * @return int
     */
    public function getLastLogin() {
        $date = parent::getLastLogin();

        if ($date != null) {
            return $date->getTimestamp() * 1000;
        }

        return 0;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setLastUpdate() {
        parent::setLastUpdate();
    }

    /**
     * @return array
     */
    public function getBaseView() {
        return array(
            'id' => $this->getId(),
            'identifier' => $this->getIdentifier(),
            'created' => $this->getCreated(),
            'last_update' => $this->getLastUpdate(),
            'last_login' => $this->getLastLogin(),
            'email' => $this->getEmail(),
            'username' => $this->getUsername(),
        );
    }

    /**
     * @return array
     */
    public function getExtendView()
    {
        $view = $this->getBaseView();

        $companiesView = array();

        $companies = $this->getCompanies();

        /** @var Company $c */
        foreach ($companies as $c) {
            $companiesView[] = $c->getBaseView();
        }

        $view['companies'] = $companiesView;

        return $view;
    }

}
