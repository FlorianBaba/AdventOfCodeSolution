<?php

/**
 * @author: FlorianBaba
 * Date: 01/01/16
 */
class PersonRelation
{
    /**
     * @var string
     */
    private $relatedPersonName;

    /**
     * @var float
     */
    private $happinessPoints;

    /**
     * @param $relatedPersonName
     * @param $happinessPoints
     */
    public function __construct($relatedPersonName, $happinessPoints)
    {
        $this->relatedPersonName = $relatedPersonName;
        $this->happinessPoints = $happinessPoints;
    }

    /**
     * @return string
     */
    public function getRelatedPersonName()
    {
        return $this->relatedPersonName;
    }

    /**
     * @return float
     */
    public function getHappinessPoints()
    {
        return $this->happinessPoints;
    }
}
