<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 13/07/16
 * Time: 14:47
 */

namespace ActivisMap\Base;

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
     * @param int $startDate
     * @param int $endDate
     * @param int $limit
     * @param int $offset
     * @param Area $area
     * @param bool|true $asView
     * @return array
     */
    public function searchEvents($type = 'ALL', $startDate = 0, $endDate = 0, $limit = 20, $offset = 1, $area = null, $asView = true) {
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

        $queryBuilder->where('e.startDate >= :start_date')
            ->andWhere('e.endDate <= :end_date')
            ->setParameter('start_date', $startDate)
            ->setParameter('end_date', $endDate);

        if ($area != null) {
            $queryBuilder
                ->andWhere('e.latitude <= ' . $area->getLat1())
                ->andWhere('e.latitude >= ' . $area->getLat2())
                ->andWhere('e.longitude <= ' . $area->getLng1())
                ->andWhere('e.longitude >= ' . $area->getLng2());
        }

        if ($type != null && $type != 'ALL') {
            $queryBuilder
                ->andWhere('e.type = :type');
        }


        $queryBuilder->andWhere('e.status = "WORKING"')
            ->setParameter('type', $type)
            ->setFirstResult($offset)
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
}