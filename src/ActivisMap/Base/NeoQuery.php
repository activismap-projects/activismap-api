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
use ActivisMap\Util\EntityUtils;
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

    /**
     * @param string|null $type
     * @param string $category
     * @param bool|true $asView
     * @return array
     */
    public function searchActivities($type = 'ALL', $category = 'ALL', $asView = true) {
        $type = strtoupper($type);
        $category = strtoupper($category);

        if ($type != null && $type != 'ALL') {
            $query = $this->em->createCypherQuery()
                ->match('(a:Activity)')
                ->where('a.status = "WORKING" AND a.start_date >= ' . EntityUtils::millis() . ' AND a.end_date <= ' . (EntityUtils::millis() + 2592000000) . ' AND a.type = "' . $type . '"')
                ->end('a');
            $acts = $query
                ->getList()->toArray();
        } else {
            $query = $this->em->createCypherQuery()
                ->match('(a:Activity)')
                ->where('a.status = "WORKING" AND a.start_date >= ' . EntityUtils::millis() . ' AND a.end_date <= ' . (EntityUtils::millis() + 2592000000))
                ->end('a');
            $acts = $query
                ->getList()->toArray();
        }

        //die(print_r($query->getQuery(), true));


        if ($asView) {
            $views = array();
            foreach ($acts as $a) {
                /** @var Activity $a */
                $views[] = $a->getExtendView();
            }

            return $views;
        }

        return $acts;
    }
}