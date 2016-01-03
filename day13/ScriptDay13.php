<?php

require_once __DIR__.'/../lib/AbstractScriptDay.php';
require_once __DIR__.'/PersonCollection.php';


/**
 * @author: FlorianBaba
 * Date: 18/12/15
 */
class ScriptDay13 extends AbstractScriptDay
{
    /**
     * {@inheritdoc}
     */
    protected function getAnswer($part)
    {
        $includeMe = ($part === 2);
        $personCollection = new PersonCollection($includeMe);

        while ($instruction = $this->getNextInstruction()) {
            $pattern = '/^(?P<subject>\w+) would (?<action>gain|lose) (?<points>\d+) happiness units by sitting next to (?P<neighbor>\w+).$/';
            preg_match($pattern, $instruction, $matches);

            if (!isset($matches['subject'])) {
                throw new ErrorException(sprintf('Unexpected instruction : %s', $instruction));
            }

            $sign = ($matches['action'] === 'gain') ? '' : '-';
            $points = (int)($sign.$matches['points']);
            $personCollection->updatePerson($matches['subject'], $matches['neighbor'], $points);
        }

        $tableConfigurationList = $this->getTableConfigurationList($personCollection->getPersonNameList());

        $maxHappiness = 0;
        foreach ($tableConfigurationList as $tableConfiguration) {
            $totalHappiness = $this->getHappinessPointsByTableConfiguration($personCollection, $tableConfiguration);
            if ($totalHappiness > $maxHappiness) {
                $maxHappiness = $totalHappiness;
            }
        }

        return 'The maximum of happiness is : '.$maxHappiness;
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return 'Day 13';
    }

    /**
     * {@inheritdoc}
     */
    protected function getInstructionsFilePath()
    {
        return __DIR__.'/instructions.txt';
    }

    /**
     * @param PersonCollection $personCollection
     * @param array $tableConfiguration
     * @return float|int
     */
    private function getHappinessPointsByTableConfiguration(
        PersonCollection $personCollection,
        array $tableConfiguration
    ) {
        $lastKey = $personCollection->getNbPersons() - 1;
        $totalHappiness = 0;

        foreach ($tableConfiguration as $key => $personName) {
            $leftNeighborName = $key > 0 ? $tableConfiguration[$key - 1] : $tableConfiguration[$lastKey];
            $rightNeighborName = $key < $lastKey ? $tableConfiguration[$key + 1] : $tableConfiguration[0];
            $totalHappiness += $personCollection->getHappinessPoints($personName, $leftNeighborName);
            $totalHappiness += $personCollection->getHappinessPoints($personName, $rightNeighborName);
        }

        return $totalHappiness;
    }

    /**
     * @param array $listPersonName
     * @return array
     */
    private function getTableConfigurationList(array $listPersonName)
    {
        $configurationList = array();
        $this->getPossibilities($listPersonName, array(), $configurationList);

        return $configurationList;
    }

    /**
     * @param $items
     * @param array $perms
     * @param array $results
     */
    private function getPossibilities($items, $perms = array(), &$results = array())
    {
        if (empty($items)) {
            $results[] = $perms;
        } else {
            for ($i = count($items) - 1; $i >= 0; --$i) {
                $newitems = $items;
                $newperms = $perms;
                list($foo) = array_splice($newitems, $i, 1);
                array_unshift($newperms, $foo);
                $this->getPossibilities($newitems, $newperms, $results);
            }
        }
    }
}
