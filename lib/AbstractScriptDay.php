<?php

/**
 * @author: FlorianBaba
 * Date: 12/12/15
 */
abstract class AbstractScriptDay
{
    /**
     * @var SplFileObject
     */
    private $instructionsFile;

    public function __construct()
    {
        $this->instructionsFile = new SplFileObject($this->getInstructionsFilePath());
    }

    /**
     * @return string
     */
    public function getSolution()
    {
        $txt = '***** Solution - '.$this->getName().' *****'.PHP_EOL;

        foreach (array(1, 2) as $part) {
            try {
                $txt .= '- Part '.$part.' : '.$this->getAnswer($part).PHP_EOL;
                $this->instructionsFile->rewind();
            } catch (Exception $exception) {
                $txt .= 'Exception while executing part '.$part.' : '.$exception->getMessage().PHP_EOL;
            }

        }

        return $txt;
    }

    /**
     * @return SplFileObject
     */
    protected function getInstructionsFile()
    {
        return $this->instructionsFile;
    }

    /**
     * @return string
     */
    protected function getNextInstruction()
    {
        $this->instructionsFile->next();

        return $this->instructionsFile->current();
    }

    /**
     * @param $part
     * @return string
     */
    abstract protected function getAnswer($part);

    /**
     * @return string
     */
    abstract protected function getName();

    /**
     * @return string
     */
    abstract protected function getInstructionsFilePath();
}
