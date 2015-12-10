<?php

/**
 * User: FlorianBaba
 * Date: 08/12/15
 */
class WireCalculator
{
    /**
     * @var array
     */
    private $calculations;

    /**
     * @var array
     */
    private $wires;

    public function __construct()
    {
        $this->calculations = array();
        $this->wires = array();
    }

    /**
     * @param $wireKey
     * @throws ErrorException
     */
    private function getCalculation($wireKey)
    {
        if (!isset($this->calculations[$wireKey])) {
            throw new ErrorException('No calculation found for '.$wireKey);
        }

        return $this->calculations[$wireKey];
    }

    /**
     * @param $wireKey
     * @return bool|int|string
     * @throws ErrorException
     */
    public function getWireValue($wireKey)
    {
        $calculation = $this->getCalculation($wireKey);

        return $this->getWireValueFromCalculation($calculation);
    }

    /**
     * @param $instruction
     */
    public function updateCalculations($instruction)
    {
        list($calculation, $wireKey) = explode(' -> ', $instruction);
        $this->calculations[$wireKey] = $calculation;
    }

    /**
     * @param $wireKey
     * @param $value
     */
    public function updateWireValue($wireKey, $value)
    {
        $this->wires[$wireKey] = $value;
    }

    /**
     * @param $item
     * @return int|string
     * @throws ErrorException
     */
    private function getValueFromItem($item)
    {
        if ($item === null) {
            throw new ErrorException('Item value is null');
        }

        try {
            $value = $this->getNumberValue($item);
        } catch (Exception $exception) {
            $wireKey = $this->getWireKeyFormItem($item);
            $calculation = $this->getCalculation($wireKey);
            if (!isset($this->wires[$wireKey])) {
                $this->updateWireValue($wireKey, $this->getWireValueFromCalculation($calculation));
            }
            $value = $this->wires[$wireKey];
        }

        return $value;
    }

    /**
     * @param $calculation
     * @return bool|int|string
     * @throws ErrorException
     */
    private function getWireValueFromCalculation($calculation)
    {
        $action = $this->getAction($calculation);

        $items = explode($action, $calculation);

        $firstItem = isset($items[0]) ? trim($items[0]) : null;
        $secondItem = isset($items[1]) ? trim($items[1]) : null;

        switch ($action) {

            case 'SET':
                $value = $this->getValueFromItem($firstItem);
                break;

            case 'AND':
                $value = $this->getValueFromItem($firstItem) & $this->getValueFromItem($secondItem);
                break;

            case 'OR':
                $value = $this->getValueFromItem($firstItem) | $this->getValueFromItem($secondItem);
                break;

            case 'NOT':
                $value = 65535 - $this->getValueFromItem($secondItem);
                break;

            case 'RSHIFT':
                $value = $this->getValueFromItem($firstItem) >> $this->getValueFromItem($secondItem);
                break;

            case 'LSHIFT':
                $value = $this->getValueFromItem($firstItem) << $this->getValueFromItem($secondItem);
                break;

            default:
                throw new ErrorException('No action found in : '.$calculation);
                break;
        }

        return $value;
    }

    /**
     * @param $instruction
     * @return string
     * @throws ErrorException
     */
    private function getAction($instruction)
    {
        $action = 'SET';

        preg_match('/AND|OR|NOT|RSHIFT|LSHIFT/', $instruction, $matches);
        if (!empty($matches)) {
            $action = trim(array_shift($matches));
        }

        return $action;
    }

    /**
     * @param $item
     * @return string
     * @throws ErrorException
     */
    private function getWireKeyFormItem($item)
    {
        preg_match('/[a-z]{1,2}/', $item, $matches);
        if (empty($matches)) {
            throw new ErrorException('No key found in : '.$item);
        }

        return array_shift($matches);
    }

    /**
     * @param $instruction
     * @return int
     * @throws ErrorException
     */
    private function getNumberValue($instruction)
    {
        preg_match('/[0-9]+/', $instruction, $matches);
        if (empty($matches)) {
            throw new ErrorException('No value found in : '.$instruction);
        }

        return (int)array_shift($matches);
    }
}
