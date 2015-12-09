<?php

/**
 * User: FlorianBaba
 * Date: 08/12/15
 */
class WireList
{
    /**
     * @var array
     */
    private $wires;

    public function __construct()
    {
        $this->wires = array();
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->wires;
    }

    /**
     * @param $instruction
     */
    public function updateWireFromInstruction($instruction)
    {
        list($fromInstruction, $destinationWireKey) = explode(' -> ', $instruction);
        $value = $this->deductValueFromInstruction($fromInstruction);
        $this->updateWire($destinationWireKey, $value);
    }

    /**
     * @param $item
     * @return int
     */
    private function getValueFromItem($item)
    {
        try {
            $value = $this->getNumberValue($item);
        } catch (Exception $exception) {
            $value = $this->getWireValueFormItem($item);
        }

        return $value;
    }

    /**
     * @param $instruction
     * @return bool|int|string
     * @throws ErrorException
     */
    private function deductValueFromInstruction($instruction)
    {
        $action = $this->getAction($instruction);

        $items = explode($action, $instruction);

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
                throw new ErrorException('No action found in : '.$instruction);
                break;
        }

        return $value;
    }

    /**
     * @param $wireKey
     * @param $value
     */
    private function updateWire($wireKey, $value)
    {
        $this->initWire($wireKey);
        $this->wires[$wireKey] = (int)$value;
    }

    /**
     * @param $wireKey
     * @return int
     */
    private function getWireValue($wireKey)
    {
        return !empty($this->wires[$wireKey]) ? (int)$this->wires[$wireKey] : 0;
    }

    /**
     * @param $wireKey
     */
    private function initWire($wireKey)
    {
        if (empty($this->wires[$wireKey])) {
            $this->wires[$wireKey] = 0;
        }
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
    private function getWireValueFormItem($item)
    {
        $key = $this->getWireKeyFormItem($item);

        return $this->getWireValue($key);
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
