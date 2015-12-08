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
        $destinationWireKey = array_pop(explode(' -> ', $instruction));
        $value = $this->deductValueFormInstruction($instruction);
        $this->updateWire($destinationWireKey, $value);
    }

    /**
     * @param $instruction
     * @return bool|int|string
     * @throws ErrorException
     */
    private function deductValueFormInstruction($instruction)
    {
        switch ($this->getAction($instruction)) {

            case 'SET':
                $value = $this->getNumberValue($instruction);
                break;

            case 'AND':
                $value = $this->getFirstWireValue($instruction) & $this->getSecondWireValue($instruction);
                break;

            case 'OR':
                $value = $this->getFirstWireValue($instruction) | $this->getSecondWireValue($instruction);
                break;

            case 'NOT':
                $value = 65535 - $this->getFirstWireValue($instruction);
                break;

            case 'RSHIFT':
                $value = $this->getFirstWireValue($instruction) >> $this->getNumberValue($instruction);
                break;

            case 'LSHIFT':
                $value = $this->getFirstWireValue($instruction) << $this->getNumberValue($instruction);
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
     * @param $instruction
     * @return string
     * @throws ErrorException
     */
    private function getFirstWireValue($instruction)
    {
        $key = array_shift($this->getWireKeys($instruction));

        return $this->getWireValue($key);
    }

    /**
     * @param $instruction
     * @return string
     * @throws ErrorException
     */
    private function getSecondWireValue($instruction)
    {
        $wireKeys = $this->getWireKeys($instruction);
        if (count($wireKeys) < 2) {
            throw new ErrorException('No second key found in : '.$instruction);
        }

        return $this->getWireValue($wireKeys[1]);
    }

    /**
     * @param $instruction
     * @return string
     * @throws ErrorException
     */
    private function getWireKeys($instruction)
    {
        preg_match_all('/[a-z]{1,2}/', $instruction, $matches);
        if (empty($matches)) {
            throw new ErrorException('No key found in : '.$instruction);
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
