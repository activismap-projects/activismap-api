<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 26/10/16
 * Time: 17:55
 */

namespace ActivisMap\Util;


class Area {

    /** @var float */
    private $lat1;

    /** @var float */
    private $lat2;

    /** @var float */
    private $lng1;

    /** @var float */
    private $lng2;

    /**
     * Area constructor.
     * @param float $lat1
     * @param float $lat2
     * @param float $lng1
     * @param float $lng2
     */
    public function __construct($lat1, $lng1, $lat2, $lng2) {
        $this->lat1 = max($lat1, $lat2);
        $this->lat2 = min($lat1, $lat2);
        $this->lng1 = max($lng1, $lng2);
        $this->lng2 = min($lng1, $lng2);
    }

    /**
     * @return float
     */
    public function getLat1()
    {
        return $this->lat1;
    }

    /**
     * @return float
     */
    public function getLat2()
    {
        return $this->lat2;
    }

    /**
     * @return float
     */
    public function getLng1()
    {
        return $this->lng1;
    }

    /**
     * @return float
     */
    public function getLng2()
    {
        return $this->lng2;
    }

    /**
     * @param float $lat
     * @param float $lng
     * @return bool
     */
    public function isInArea($lat, $lng) {
        return ($lat <= $this->getLat1() && $lat >= $this->getLat2()) && ($lng <= $this->getLng1() && $lng >= $this->getLng2());
    }

    /**
     * @return array
     */
    public function getCenter() {
        $lat = ($this->lat1 + $this->lat2) / 2;
        $lng = ($this->lng1 + $this->lng2) / 2;

        return array(
            'latitude' => $lat,
            'longitude' => $lng,
        );
    }

}