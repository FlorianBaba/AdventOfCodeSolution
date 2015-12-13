<?php

require_once __DIR__.'/../lib/AbstractScriptDay.php';

/**
 * @author: FlorianBaba
 * Date: 13/12/15
 */
class ScriptDay10 extends AbstractScriptDay
{
    /**
     * {@inheritdoc}
     */
    protected function getAnswer($part)
    {
        $digits = $this->getNextInstruction();

        $nbLoop = ($part === 1) ? 40 : 50;

        for ($i = 0; $i < $nbLoop; $i++) {
            $digits = $this->transformDigits($digits);
        }

        return 'The answer is : '.strlen($digits);
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return 'Day 10';
    }

    /**
     * {@inheritdoc}
     */
    protected function getInstructionsFilePath()
    {
        return __DIR__.'/instructions.txt';
    }

    /**
     * @param string $digits
     * @return string
     */
    private function transformDigits($digits) {
        $actualDigit = null;
        $countActualDigit = 0;
        $result = '';

        foreach (str_split($digits) as $digit) {
            if (!empty($actualDigit) && $digit !== $actualDigit) {
                $result .= $countActualDigit.$actualDigit;
                $countActualDigit = 0;
            }
            $countActualDigit++;
            $actualDigit = $digit;
        }

        $result .= $countActualDigit.$actualDigit;

        return $result;
    }
}
