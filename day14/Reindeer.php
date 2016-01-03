<?php

/**
 * @author: FlorianBaba
 * Date: 03/01/16
 */
class Reindeer
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $distanceBySecond;

    /**
     * @var int
     */
    private $actualDistance;

    /**
     * @var int
     */
    private $maxStamina;

    /**
     * @var int
     */
    private $actualStamina;

    /**
     * @var int
     */
    private $restDuration;

    /**
     * @var int
     */
    private $actualRestingTime;

    /**
     * @var int
     */
    private $points;

    /**
     * @param string $name
     * @param int $distanceBySecond
     * @param int $stamina
     * @param int $restDuration
     */
    public function __construct($name, $distanceBySecond, $stamina, $restDuration)
    {
        $this->name = $name;
        $this->distanceBySecond = (int)$distanceBySecond;
        $this->maxStamina = (int)$stamina;
        $this->actualStamina = (int)$stamina;
        $this->restDuration = (int)$restDuration;
        $this->actualDistance = 0;
        $this->actualRestingTime = 0;
        $this->points = 0;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getActualDistance()
    {
        return $this->actualDistance;
    }

    /**
     * @return string
     */
    public function getPoints()
    {
        return $this->points;
    }

    public function incrementPoints()
    {
        $this->points++;
    }

    public function move()
    {
        if ($this->actualStamina > 0) {
            $this->actualDistance += $this->distanceBySecond;
            $this->actualStamina--;
        } else {
            $this->actualRestingTime++;
            if ($this->actualRestingTime >= $this->restDuration) {
                $this->actualRestingTime = 0;
                $this->actualStamina = $this->maxStamina;
            }
        }
    }
}
