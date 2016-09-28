<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 13/07/16
 * Time: 14:47
 */

namespace ActivisMap\Base;

use ActivisMap\Entity\Activity;
use ActivisMap\Entity\Alert;
use ActivisMap\Entity\Application;
use ActivisMap\Entity\NeoUser;
use HireVoice\Neo4j\EntityManager;

class NeoQuery {

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * @param NeoUser $user
     * @param string $status
     * @param bool|true $asView
     * @return array
     */
    public function getActivityByUser(NeoUser $user, $status = 'ENABLE', $asView = false) {
        $acts = $this->em->createCypherQuery()
            ->startWithNode('u', array($user))
            ->match('(u) <-[CREATED_BY]-(a:Activity)')
            ->where('a.status = "' . $status . '"')
            ->end('a')
            ->getList()->getValues();

        if ($asView) {
            $views = array();
            foreach ($acts as $a) {
                /** @var Activity $a */
                $views[] = $a->getBaseView();
            }

            return $views;
        }

        return $acts;
    }

    /**
     * @param Activity $act
     * @param string $status
     * @param bool|false $asView
     * @return array
     */
    public function getAlertsByActivity(Activity $act, $status = 'PENDING', $asView = false) {
        $acts = $this->em->createCypherQuery()
            ->startWithNode('u', array($act))
            ->match('(u) <-[CREATED_BY]-(a:Alert)')
            ->where('a.status = "' . $status . '"')
            ->end('a')
            ->getList()->getValues();

        if ($asView) {
            $views = array();
            foreach ($acts as $a) {
                /** @var Alert $a */
                $views[] = $a->getBaseView();
            }

            return $views;
        }

        return $acts;
    }
}