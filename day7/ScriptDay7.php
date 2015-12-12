<?php

require_once __DIR__.'/../lib/AbstractScriptDay.php';
require_once __DIR__.'/WireCalculator.php';

/**
 * @author: FlorianBaba
 * Date: 12/12/15
 */
class ScriptDay7 extends AbstractScriptDay
{
    /**
     * {@inheritdoc}
     */
    protected function getAnswer($part)
    {
        $wireList = new WireCalculator();

        if ($part === 2) {
            $wireList->updateWireValue('b', 46065);
        }

        while ($instruction = $this->getNextInstruction()) {
            $wireList->updateCalculations($instruction);
        }

        return 'The final signal for wire a is : '.$wireList->getWireValue('a');
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return 'Day 7';
    }

    /**
     * {@inheritdoc}
     */
    protected function getInstructionsFilePath()
    {
        return __DIR__.'/instructions.txt';
    }
}
