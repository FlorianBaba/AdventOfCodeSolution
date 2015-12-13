<?php

require_once __DIR__.'/../lib/AbstractScriptDay.php';

/**
 * @author: FlorianBaba
 * Date: 13/12/15
 */
class ScriptDay8 extends AbstractScriptDay
{
    /**
     * @var int
     */
    private $totalCharLiterals;

    /**
     * @var int
     */
    private $totalCharInMemory;

    /**
     * @var int
     */
    private $totalCharNewlyEncoded;

    private function resetAllTotals()
    {
        $this->totalCharLiterals = 0;
        $this->totalCharInMemory = 0;
        $this->totalCharNewlyEncoded = 0;
    }

    /**
     * {@inheritdoc}
     */
    protected function getAnswer($part)
    {
        $this->resetAllTotals();

        while ($instruction = $this->getNextInstruction()) {

            // init count
            $countCharLiterals = strlen($instruction);
            $countCharNewlyEncoded = strlen(addslashes($instruction)) + 2;

            ob_start();
            eval("echo ".$instruction.";");
            $output = ob_get_contents();
            ob_end_clean();
            $countCharInMemory = strlen($output);

            // final count
            $this->totalCharLiterals += $countCharLiterals;
            $this->totalCharInMemory += $countCharInMemory;
            $this->totalCharNewlyEncoded += $countCharNewlyEncoded;
        }

        if ($part === 1) {
            $answer = 'The answer is : '.($this->totalCharLiterals - $this->totalCharInMemory);
        } else {
            $answer = 'The answer is : '.($this->totalCharNewlyEncoded - $this->totalCharLiterals);
        }

        return $answer;
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return 'Day 8';
    }

    /**
     * {@inheritdoc}
     */
    protected function getInstructionsFilePath()
    {
        return __DIR__.'/instructions.txt';
    }
}
