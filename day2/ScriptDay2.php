<?php

require_once __DIR__.'/../lib/AbstractScriptDay.php';

/**
 * @author: FlorianBaba
 * Date: 12/12/15
 */
class ScriptDay2 extends AbstractScriptDay
{
    /**
     * {@inheritdoc}
     */
    protected function getAnswer($part)
    {
        $totalSquare = $totalRibbonSize = 0;

        while ($lign = $this->getNextInstruction()) {
            list($l, $w, $h) = explode('x', $lign);
            $totalSquare += $this->getSquare($l, $w, $h);
            $totalRibbonSize += $this->getRibbonSize($l, $w, $h);
        }

        if ($part === 1) {
            $answer = 'The total square is '.$totalSquare;
        } else {
            $answer = 'The total ribbon size is '.$totalRibbonSize;
        }

        return $answer;
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return 'Day 2';
    }

    /**
     * {@inheritdoc}
     */
    protected function getInstructionsFilePath()
    {
        return __DIR__.'/instructions.txt';
    }

    /**
     * @param $l
     * @param $w
     * @param $h
     * @return int
     */
    private function getSquare($l, $w, $h)
    {
        $squareOfThePresent = 2 * $l * $w + 2 * $w * $h + 2 * $h * $l;
        $squareOfTheSmallestSide = min(array($l * $w, $l * $h, $w * $h));

        return $squareOfThePresent + $squareOfTheSmallestSide;
    }

    /**
     * @param $l
     * @param $w
     * @param $h
     * @return int
     */
    private function getRibbonSize($l, $w, $h)
    {
        $dimensions = array($l, $w, $h);

        return (array_sum($dimensions) - max($dimensions)) * 2 + $l * $w * $h;
    }
}
