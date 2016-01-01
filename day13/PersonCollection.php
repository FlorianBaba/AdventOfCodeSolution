<?php

require_once __DIR__.'/Person.php';

/**
 * @author: FlorianBaba
 * Date: 01/01/16
 */
class PersonCollection
{
    /**
     * @var Person[]
     */
    private $personList;

    public function __construct()
    {
        $this->personList = array();
    }

    /**
     * @param string $personName
     * @param string $neighborName
     * @param int $happinessPoints
     */
    public function updatePerson($personName, $neighborName, $happinessPoints)
    {
        $person = $this->getPersonByName($personName);
        $person->addPersonRelation($neighborName, $happinessPoints);
    }

    /**
     * @return int
     */
    public function getNbPersons()
    {
        return count($this->personList);
    }

    /**
     * @param $subjectName
     * @param $neighborName
     * @return float
     * @throws ErrorException
     */
    public function getHappinessPoints($subjectName, $neighborName)
    {
        $subject = $this->getPersonByName($subjectName);

        return $subject->getHappinessPointsByNeighbor($neighborName);
    }

    /**
     * @return array
     */
    public function getPersonNameList()
    {
        $personNameList = array();

        foreach ($this->personList as $person) {
            $personNameList[] = $person->getName();
        }

        return $personNameList;
    }

    /**
     * @param string $name
     * @return Person
     */
    private function getPersonByName($name)
    {
        foreach ($this->personList as $person) {
            if ($person->getName() === $name) {
                return $person;
            }
        }

        $person = new Person($name);
        $this->personList[] = $person;

        return $person;
    }
}
