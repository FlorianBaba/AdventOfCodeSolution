<?php

require_once __DIR__.'/../lib/AbstractScriptDay.php';

/**
 * @author: FlorianBaba
 * Date: 12/12/15
 */
class ScriptDay5 extends AbstractScriptDay
{
    /**
     * @var array
     */
    static $vowels = array('a', 'e', 'i', 'o', 'u');

    /**
     * {@inheritdoc}
     */
    protected function getAnswer($part)
    {
        $nbGoodWords = 0;
        while ($word = $this->getNextInstruction()) {

            // Is it a good word ?
            if ($this->isAGoodWord($word, $part)) {
                $nbGoodWords++;
            }
        }

        return 'The number of good words is '.$nbGoodWords;
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return 'Day 5';
    }

    /**
     * {@inheritdoc}
     */
    protected function getInstructionsFilePath()
    {
        return __DIR__.'/instructions.txt';
    }

    /**
     * @param string $word
     * @param int $part1
     * @return bool
     */
    private function isAGoodWord($word, $part1)
    {
        switch ($part1) {
            // part 1
            case 1:
                return $this->isAGoodWordForPart1($word);
                break;

            // part 2
            case 2:
                return $this->isAGoodWordForPart2($word);
                break;

            default:
                return false;
        }
    }

    /**
     * @param string $word
     * @return bool
     */
    private function isAGoodWordForPart1($word)
    {
        $hasDoubleLetters = false;
        $previousLetter = null;
        $nbVowels = 0;
        foreach (str_split($word) as $letter) {
            if (in_array($letter, self::$vowels)) {
                $nbVowels++;
            }
            if ($previousLetter === $letter) {
                $hasDoubleLetters = true;
            }

            $previousLetter = $letter;
        }

        // checking the word contains 3 vowels and has a double letters
        if ($nbVowels < 3 || !$hasDoubleLetters) {
            return false;
        }

        // check for forbidden string
        foreach (array('ab', 'cd', 'pq', 'xy') as $forbiddenString) {
            if (strpos($word, $forbiddenString) !== false) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $word
     * @return bool
     */
    private function isAGoodWordForPart2($word)
    {
        $containsSandwichLetter = $containsPairOfTwoLetters = false;
        $previousLetter = null;

        foreach (str_split($word) as $offset => $letter) {

            // searching for pair of two letters
            if ($previousLetter !== null) {
                preg_match('/'.$previousLetter.$letter.'/', $word, $matches, PREG_OFFSET_CAPTURE, $offset + 1);
                if (!empty($matches)) {
                    $containsPairOfTwoLetters = true;
                }
            }

            // searching for a sandwich letter
            preg_match('/'.$letter.'[a-z]'.$letter.'/', $word, $matches);
            if (!empty($matches)) {
                $containsSandwichLetter = true;
            }

            $previousLetter = $letter;
        }

        return $containsPairOfTwoLetters && $containsSandwichLetter;
    }
}
