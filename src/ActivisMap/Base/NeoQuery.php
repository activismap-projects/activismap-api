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
use ActivisMap\Util\Area;
use ActivisMap\Util\EntityUtils;
use HireVoice\Neo4j\EntityManager;
use Psr\Log\LoggerInterface;

class NeoQuery {

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(EntityManager $em, LoggerInterface $logger) {
        $this->em = $em;
        $this->logger = $logger;
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

    public function getActivity($id, $asView =false) {
        $acts = $this->em->createCypherQuery()
            ->match('(a:Application)')
            ->where('ID(a) = ' . $id);
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
     * @param int $startDate
     * @param int $endDate
     * @param int $limit
     * @param int $offset
     * @param Area $area
     * @param bool|true $asView
     * @return array
     */
    public function searchActivities($type = 'ALL', $startDate = 0, $endDate = 0, $limit = 20, $offset = 1, $area = null, $asView = true) {
        $type = strtoupper($type);

        if ($startDate > 0) {
            $start = 'AND a.start_date >= ' . $startDate;
        } else {
            $start = 'AND a.start_date >= ' . EntityUtils::millis();
        }

        if ($endDate > 0) {
            $end = 'AND a.end_date <= ' . $endDate;
        } else {
            $end = 'AND a.end_date <= ' . (EntityUtils::millis() + 2592000000);
        }

        $areaQuery = '';
        if ($area != null) {
            $areaQuery = ' AND a.latitude <= ' . $area->getLat1() . ' AND a.latitude >=' . $area->getLat2() .
                ' AND a.longitude <= ' . $area->getLng1() . ' AND a.longitude >= ' . $area->getLng2();
        }

        if ($type != null && $type != 'ALL') {
            $query = $this->em->createCypherQuery()
                ->match('(a:Activity)')
                ->where('a.status = "WORKING" ' . $start . ' ' . $end . ' AND a.type = "' . $type . '" ' . $areaQuery )
                ->end('a')
                ->skip('' . (($limit * $offset) - $limit));
            $acts = $query
                ->getList()->toArray();
        } else {
            $query = $this->em->createCypherQuery()
                ->match('(a:Activity)')
                ->where('a.status = "WORKING" ' . $start . ' ' . $end . ' ' .  $areaQuery )
                ->end('a')
                ->skip('' . (($limit * $offset) - $limit));
            $acts = $query
                ->getList()->toArray();
        }

        $class = get_class($query);
        $rClass = new \ReflectionClass($class);
        $prop = $rClass->getProperty('query');
        $prop->setAccessible(true);

        $queryString  = $prop->getValue($query);
        $this->logger->error('SEARCH QUERY: ' . $queryString);

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