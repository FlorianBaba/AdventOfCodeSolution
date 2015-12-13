<?php

require_once __DIR__.'/../lib/AbstractScriptDay.php';

/**
 * @author: FlorianBaba
 * Date: 13/12/15
 */
class ScriptDay11 extends AbstractScriptDay
{
    /**
     * @var array
     */
    private $suiteLetters;

    public function __construct()
    {
        parent::__construct();
        $this->suiteLetters = $this->getSuiteLetters();
    }

    /**
     * {@inheritdoc}
     */
    protected function getAnswer($part)
    {
        $password = $this->getNextInstruction();
        $nbLoop = ($part === 1) ? 1 : 2;

        for ($i = 0; $i < $nbLoop; $i++) {
            $password = $this->getNextPassword($password);
        }

        $answer = 'The new password is : '.$password;

        return $answer;
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return 'Day 11';
    }

    /**
     * {@inheritdoc}
     */
    protected function getInstructionsFilePath()
    {
        return __DIR__.'/instructions.txt';
    }

    /**
     * @return array
     */
    private function getSuiteLetters()
    {
        $alpha = 'abcdefghijklmnopqrstuvwxyz';
        $actualLetters = $suiteLetters = array();

        foreach (str_split($alpha) as $letter) {
            $actualLetters[] = $letter;
            $nbActualLetters = count($actualLetters);
            if ($nbActualLetters < 3) {
                continue;
            } else {
                $suiteLetters[] = implode('', $actualLetters);
                array_shift($actualLetters);
            }
        }

        return $suiteLetters;
    }

    /**
     * @param $password
     * @return string
     */
    private function getNextPassword($password)
    {
        $newPassword = '';
        $forbiddenLetters = array('i', 'o', 'l');

        while (++$password) {
            $doubleLetters = array();
            $hasSuite = false;

            $actualLetter = null;
            $actualSuiteLetters = array();

            foreach (str_split($password) as $letter) {

                if (in_array($letter, $forbiddenLetters)) {
                    break;
                }

                $actualSuiteLetters[] = $letter;
                if ($actualLetter === $letter) {
                    $doubleLetters[] = $letter;
                }

                $nbActualLetters = count($actualSuiteLetters);
                if ($nbActualLetters === 3) {
                    if (in_array(implode('', $actualSuiteLetters), $this->suiteLetters)) {
                        $hasSuite = true;
                    }
                    array_shift($actualSuiteLetters);
                }

                $actualLetter = $letter;
            }

            $nbDouble = count(array_unique($doubleLetters));

            // check
            if ($hasSuite && $nbDouble >= 2) {
                $newPassword = $password;
                break;
            }
        }

        return $newPassword;
    }
}
