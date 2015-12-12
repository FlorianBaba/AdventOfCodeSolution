<?php

require_once __DIR__.'/../lib/AbstractScriptDay.php';

/**
 * @author: FlorianBaba
 * Date: 12/12/15
 */
class ScriptDay1 extends AbstractScriptDay
{
    /**
     * {@inheritdoc}
     */
    protected function getAnswer($part)
    {
        $actualLvl = 0;
        $lvlEnterBasement = null;
        $instruction = $this->getNextInstruction();

        foreach (str_split($instruction) as $key => $character) {
            switch ($character) {
                case '(' :
                    $actualLvl++;
                    break;
                case ')' :
                    $actualLvl--;
                    break;
            }

            if ($lvlEnterBasement === null && $actualLvl < 0) {
                $lvlEnterBasement = $key + 1;
            }
        }

        return ($part === 1) ? $actualLvl : $lvlEnterBasement;
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return 'Day 1';
    }

    /**
     * {@inheritdoc}
     */
    protected function getInstructionsFilePath()
    {
        return __DIR__.'/instructions.txt';
    }
}
