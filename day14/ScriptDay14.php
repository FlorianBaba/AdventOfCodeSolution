<?php

require_once __DIR__.'/../lib/AbstractScriptDay.php';
require_once __DIR__.'/ReindeerRace.php';

/**
 * @author: FlorianBaba
 * Date: 18/12/15
 */
class ScriptDay14 extends AbstractScriptDay
{
    const RACE_DURATION = 2503;

    /**
     * {@inheritdoc}
     */
    protected function getAnswer($part)
    {
        $reindeerRace = new ReindeerRace(self::RACE_DURATION);

        // add reindeers to the race
        while ($instruction = $this->getNextInstruction()) {
            $pattern = '#^(?P<name>\w+) can fly (?<distance_by_seconds>\d+) km/s for (?<stamina>\d+) seconds, but then must rest for (?<rest_duration>\d+) seconds.$#';
            preg_match($pattern, $instruction, $matches);

            if (!isset($matches['name'])) {
                throw new ErrorException(sprintf('Unexpected instruction : %s', $instruction));
            }

            $reindeerRace->addReindeer(
                $matches['name'],
                $matches['distance_by_seconds'],
                $matches['stamina'],
                $matches['rest_duration']
            );
        }

        // race in progress
        $reindeerRace->processRace();

        // results
        if ($part === 1) {
            $winner = $reindeerRace->getWinnerByDistance();
            return 'The winner is '.$winner->getName().' with '.$winner->getActualDistance().' km';
        } else {
            $winner = $reindeerRace->getWinnerByPoints();
            return 'The winner is '.$winner->getName().' with '.$winner->getPoints().' pts';
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return 'Day 14';
    }

    /**
     * {@inheritdoc}
     */
    protected function getInstructionsFilePath()
    {
        return __DIR__.'/instructions.txt';
    }
}
