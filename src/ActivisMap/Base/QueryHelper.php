<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 13/07/16
 * Time: 14:47
 */

namespace ActivisMap\Base;

use ActivisMap\Entity\Comment;
use ActivisMap\Entity\Event;
use ActivisMap\Util\Area;
use ActivisMap\Util\EntityUtils;
use Psr\Log\LoggerInterface;

class QueryHelper {

    /**
     * @var ApiController
     */
    private $ac;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param ApiController $ac
     * @param LoggerInterface $logger
     */
    public function __construct($ac, $logger) {
        $this->ac = $ac;
        $this->logger = $logger;
    }

    /**
     * @param string|null $type
     * @param null $category
     * @param int $startDate
     * @param int $endDate
     * @param int $limit
     * @param int $offset
     * @param Area $area
     * @param bool|true $asView
     * @return array
     */
    public function searchEvents($type = 'ALL', $category = null, $startDate = 0, $endDate = 0, $limit = 20, $offset = 0, $area = null, $asView = true) {
        $type = strtoupper($type);

        $repo = $this->ac->getEventRepository();

        $queryBuilder = $repo->createQueryBuilder('e')
            ->select('e');

        if ($startDate <= 0) {
            $startDate = EntityUtils::millis();
        }

        if ($endDate <= 0) {
            $endDate = EntityUtils::millis() + 2592000000;
        }

        $this->logger->error('DATES: ', array($startDate, $endDate));

        $queryBuilder->where('e.startDate BETWEEN ' . $startDate . ' AND ' . $endDate)
            ->orWhere('e.endDate BETWEEN ' . $startDate . ' AND ' . $endDate);

        if ($area != null) {
            $queryBuilder
                ->andWhere('e.latitude <= ' . $area->getLat1())
                ->andWhere('e.latitude >= ' . $area->getLat2())
                ->andWhere('e.longitude <= ' . $area->getLng1())
                ->andWhere('e.longitude >= ' . $area->getLng2());
        }

        if ($type != null && $type != 'ALL') {
            $queryBuilder
                ->andWhere('e.type = :type')
                ->setParameter('type', $type);
        }

        if ($category != null) {
            $queryBuilder
                ->andWhere("e.categories LIKE '%" . $category . "%'");
        }


        $queryBuilder->setFirstResult($offset)
            ->setMaxResults($limit);

        $queryString  = $queryBuilder->getQuery()->getSQL();
        $this->logger->error('SEARCH QUERY: ' . $queryString);

        $acts = $queryBuilder->getQuery()->getResult();

        if ($asView) {
            $views = array();
            foreach ($acts as $a) {
                /** @var Event $a */
                $views[] = $a->getExtendView();
            }

            return $views;
        }

        return $acts;
    }

    /**
     * @param Event $event
     * @param int $limit
     * @param int $offset
     * @param bool $asView
     * @return array
     */
    public function getComments($event, $limit = 20, $offset = 0, $asView = true) {
        $repo = $this->ac->getEventRepository();

        $comments = $queryBuilder = $repo->createQueryBuilder('e')
            ->select('e')
            ->where('e.id = ' . $event->getId())
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()->getResult();

        if ($asView) {
            $views = array();
            /** @var Comment $c */
            foreach ($comments as $c) {
                $views[] = $c->getBaseView();
            }

            return $views;
        }

        return $comments;
    }
}