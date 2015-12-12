<?php

require_once __DIR__.'/../lib/AbstractScriptDay.php';

/**
 * @author: FlorianBaba
 * Date: 12/12/15
 */
class ScriptDay4 extends AbstractScriptDay
{
    const LOOP_SEARCH_LIMIT = 1000000000;

    /**
     * {@inheritdoc}
     */
    protected function getAnswer($part)
    {
        $answer = 'No AdventCoin found son !';
        $startOfMD5 = $part === 1 ? '00000' : '000000';
        $instruction = $this->getNextInstruction();

        // searching in progress ...
        for ($i = 0; $i < self::LOOP_SEARCH_LIMIT; $i++) {

            // yes ! we found it !
            if (strpos(md5($instruction.$i), $startOfMD5) === 0) {
                $answer = 'The AdventCoin is : '.$i;
                break;
            }
        }

        return $answer;
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return 'Day 4';
    }

    /**
     * {@inheritdoc}
     */
    protected function getInstructionsFilePath()
    {
        return __DIR__.'/instructions.txt';
    }
}
