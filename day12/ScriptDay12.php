<?php

require_once __DIR__.'/../lib/AbstractScriptDay.php';

/**
 * @author: FlorianBaba
 * Date: 18/12/15
 */
class ScriptDay12 extends AbstractScriptDay
{
    /**
     * {@inheritdoc}
     */
    protected function getAnswer($part)
    {
        $instruction = $this->getNextInstruction();
        $json = json_decode($instruction);
        $sum = $this->calculateSumRecursive($json, $part);

        return 'The sum is : '.$sum;
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return 'Day 12';
    }

    /**
     * {@inheritdoc}
     */
    protected function getInstructionsFilePath()
    {
        return __DIR__.'/instructions.txt';
    }

    /**
     * @param $json
     * @return int
     */
    private function calculateSumRecursive($json, $part)
    {
        $tempSum = 0;

        foreach ($json as $item) {
            if ($item instanceof stdClass || is_array($item)) {
                $tempSum += $this->calculateSumRecursive($item, $part);
            } elseif ($part === 2 && $json instanceof stdClass && $item === 'red') {
                return 0; // it's red, we need to skip it !
            } else {
                $tempSum += $item;
            }
        }
        
        return $tempSum;
    }
}
