<?php

require_once __DIR__.'/../lib/AbstractScriptDay.php';

/**
 * @author: FlorianBaba
 * Date: 12/12/15
 */
class ScriptDay3 extends AbstractScriptDay
{
    /**
     * {@inheritdoc}
     */
    protected function getAnswer($part)
    {
        $knownCoordinates = array('0-0');
        $xSanta = $ySanta = $xRobot = $yRobot = 0;
        $instruction = $this->getNextInstruction();

        foreach (str_split($instruction) as $key => $sign) {

            // move santa
            if ($part === 1 || $key % 2 === 0) {
                $this->move($xSanta, $ySanta, $sign);
            }
            // move the robot
            else {
                $this->move($xRobot, $yRobot, $sign);
            }

            // save actual coordinates
            foreach (array($xSanta.'-'.$ySanta, $xRobot.'-'.$yRobot) as $coordinates) {
                if (!in_array($coordinates, $knownCoordinates)) {
                    $knownCoordinates[] = $coordinates;
                }
            }
        }

        return 'The total of House which receive at least one present is : '.count($knownCoordinates);
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return 'Day 3';
    }

    /**
     * {@inheritdoc}
     */
    protected function getInstructionsFilePath()
    {
        return __DIR__.'/instructions.txt';
    }

    /**
     * @param int $x
     * @param int $y
     * @param string $sign
     * @throws ErrorException
     */
    private function move(&$x, &$y, $sign)
    {
        switch ($sign) {
            // go up
            case '^':
                $y++;
                break;

            // go down
            case 'v':
                $y--;
                break;

            // go left
            case '<':
                $x--;
                break;

            // go right
            case '>':
                $x++;
                break;

            default:
                throw new ErrorException(sprintf('Unknown moving sign %s', $sign));
                break;
        }
    }
}
