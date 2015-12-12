<?php

require_once __DIR__.'/../lib/AbstractScriptDay.php';

/**
 * @author: FlorianBaba
 * Date: 12/12/15
 */
class ScriptDay6 extends AbstractScriptDay
{
    /**
     * @var array
     */
    private $grid;

    public function __construct()
    {
        parent::__construct();
        $this->grid = array();
    }

    /**
     * {@inheritdoc}
     */
    protected function getAnswer($part)
    {
        // init the grid
        $this->grid = array();
        $this->actionLight(0, 0, 999, 999, 'off', 1);

        while ($instruction = $this->getNextInstruction()) {

            // get coordinates
            preg_match_all('/[0-9]{1,3},[0-9]{1,3}/', $instruction, $matches);
            if (empty($matches) || count($matches[0]) < 2) {
                throw new ErrorException('No coordinate found in : '.$instruction);
            }

            $coords = array_shift($matches);
            $xStart = $this->getXFromCoord($coords[0]);
            $yStart = $this->getYFromCoord($coords[0]);
            $xEnd = $this->getXFromCoord($coords[1]);
            $yEnd = $this->getYFromCoord($coords[1]);

            // get type of action
            preg_match('/ on | off |toggle /', $instruction, $matches);
            if (empty($matches)) {
                throw new ErrorException('No action found in : '.$instruction);
            }

            $action = trim(array_shift($matches));

            // do the action !
            $this->actionLight($xStart, $yStart, $xEnd, $yEnd, $action, $part);
        }

        return 'The number of lit lights is '.array_sum($this->grid);
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return 'Day 6';
    }

    /**
     * {@inheritdoc}
     */
    protected function getInstructionsFilePath()
    {
        return __DIR__.'/instructions.txt';
    }

    /**
     * @param $xStart
     * @param $yStart
     * @param $xEnd
     * @param $yEnd
     * @param $action
     * @param $part
     * @throws ErrorException
     */
    private function actionLight($xStart, $yStart, $xEnd, $yEnd, $action, $part)
    {
        if (!in_array($action, array('on', 'off', 'toggle'))) {
            throw new ErrorException('Unknown action : '.$action);
        }

        for ($x = $xStart; $x <= $xEnd; $x++) {
            for ($y = $yStart; $y <= $yEnd; $y++) {
                if ($part === 1) {
                    $this->actionLightForPart1($x, $y, $action);
                } else {
                    $this->actionLightForPart2($x, $y, $action);
                }
            }
        }
    }

    /**
     * @param $x
     * @param $y
     * @param $action
     */
    private function actionLightForPart1($x, $y, $action)
    {
        switch ($action) {
            case 'on' :
                $this->grid[$x.','.$y] = 1;
                break;
            case 'off' :
                $this->grid[$x.','.$y] = 0;
                break;
            case 'toggle' :
                $this->grid[$x.','.$y] = $this->grid[$x.','.$y] ? 0 : 1;
                break;
        }
    }

    /**
     * @param $x
     * @param $y
     * @param $action
     */
    private function actionLightForPart2($x, $y, $action)
    {
        switch ($action) {
            case 'on' :
                $this->grid[$x.','.$y]++;
                break;
            case 'off' :
                if ($this->grid[$x.','.$y] > 0) {
                    $this->grid[$x.','.$y]--;
                }
                break;
            case 'toggle' :
                $this->grid[$x.','.$y] += 2;
                break;
        }
    }

    /**
     * @param $coord
     * @return int
     */
    private function getXFromCoord($coord)
    {
        return array_shift(explode(',', $coord));
    }

    /**
     * @param $coord
     * @return int
     */
    private function getYFromCoord($coord)
    {
        return array_pop(explode(',', $coord));
    }
}
