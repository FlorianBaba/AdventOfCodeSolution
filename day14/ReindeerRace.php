<?php

require_once __DIR__.'/Reindeer.php';

/**
 * @author: FlorianBaba
 * Date: 03/01/16
 */
class ReindeerRace
{
    /**
     * @var Reindeer[]
     */
    private $reindeerList;

    /**
     * @var int
     */
    private $duration;

    /**
     * @param int $duration
     */
    public function __construct($duration)
    {
        $this->reindeerList = array();
        $this->duration = (int)$duration;
    }

    /**
     * @param $name
     * @param $distanceBySeconds
     * @param $stamina
     * @param $restDuration
     */
    public function addReindeer($name, $distanceBySeconds, $stamina, $restDuration)
    {
        $this->reindeerList[] = new Reindeer($name, $distanceBySeconds, $stamina, $restDuration);
    }

    /**
     * @return Reindeer
     * @throws ErrorException
     */
    public function getWinnerByPoints()
    {
        $maxPoints = 0;
        $winner = null;
        foreach ($this->reindeerList as $reindeer) {
            if ($reindeer->getPoints() > $maxPoints) {
                $maxPoints = $reindeer->getPoints();
                $winner = $reindeer;
            }
        }

        if (empty($winner)) {
            throw new ErrorException('There is no winner');
        }

        return $winner;
    }

    /**
     * @return Reindeer
     * @throws ErrorException
     */
    public function getWinnerByDistance()
    {
        return array_pop($this->getActualLeaders());
    }

    public function processRace()
    {
        // race in progress
        for ($s = 1; $s <= $this->duration; $s++) {
            foreach ($this->reindeerList as $reindeer) {
                $reindeer->move();
            }
            foreach ($this->getActualLeaders() as $leader) {
                $leader->incrementPoints();
            }
        }
    }

    /**
     * @return Reindeer[]
     * @throws ErrorException
     */
    private function getActualLeaders()
    {
        $maxDistance = 0;
        $leaders = array();
        foreach ($this->reindeerList as $reindeer) {
            if ($reindeer->getActualDistance() > $maxDistance) {
                $maxDistance = $reindeer->getActualDistance();
            }
        }

        foreach ($this->reindeerList as $reindeer) {
            if ($reindeer->getActualDistance() == $maxDistance) {
                $leaders[] = $reindeer;
            }
        }

        return $leaders;
    }
}
