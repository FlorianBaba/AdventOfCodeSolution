<?php

/**
 * @author: FlorianBaba
 * Date: 13/12/15
 */
class DeliverRoute
{
    const ROUTE_TYPE_SHORTEST = 1;
    const ROUTE_TYPE_LONGEST = 2;

    /**
     * @var array
     */
    private $usedCities;

    /**
     * @var int
     */
    private $totalDistance;

    /**
     * @var int
     */
    private $type;

    /**
     * DeliverRoute constructor.
     */
    public function __construct()
    {
        $this->usedCities = array();
        $this->totalDistance = 0;
        $this->type = self::ROUTE_TYPE_SHORTEST;
    }

    /**
     * @param $type
     * @throws ErrorException
     */
    public function setType($type)
    {
        if (!in_array($type, array(self::ROUTE_TYPE_SHORTEST, self::ROUTE_TYPE_LONGEST))) {
            throw new ErrorException(sprintf('Unknow type %d for DeliverRoute', $type));
        }

        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getUsedCities()
    {
        return $this->usedCities;
    }

    /**
     * @param string $city
     */
    public function addUsedCity($city)
    {
        if (!in_array($city, $this->usedCities)) {
            $this->usedCities[] = $city;
        }
    }

    /**
     * @param int $distance
     */
    public function addDistance($distance)
    {
        $this->totalDistance += (int)$distance;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return implode(' -> ', $this->usedCities);
    }

    /**
     * @return int
     */
    public function getTotalDistance()
    {
        return $this->totalDistance;
    }
}
