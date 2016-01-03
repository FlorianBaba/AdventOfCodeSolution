<?php

require_once __DIR__.'/PersonRelation.php';

/**
 * @author: FlorianBaba
 * Date: 01/01/16
 */
class Person
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var PersonRelation[]
     */
    private $relationList;

    /**
     * Person constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->relationList = array();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $neighborName
     * @param int $happinessPoints
     */
    public function addPersonRelation($neighborName, $happinessPoints)
    {
        $this->relationList[] = new PersonRelation($neighborName, $happinessPoints);
    }

    /**
     * @param string $neighborName
     * @return float
     * @throws ErrorException
     */
    public function getHappinessPointsByNeighbor($neighborName)
    {
        foreach ($this->relationList as $relation) {
            if ($relation->getRelatedPersonName() === $neighborName) {
                return $relation->getHappinessPoints();
            }
        }

        throw new ErrorException(sprintf('No relation found with neighbor %s for person %s', $neighborName, $this->name));
    }
}
