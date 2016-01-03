<?php

require_once __DIR__.'/Person.php';

/**
 * @author: FlorianBaba
 * Date: 03/01/16
 */
class MySelf extends Person
{
    /**
     * @param string $neighborName
     * @return float
     * @throws ErrorException
     */
    public function getHappinessPointsByNeighbor($neighborName)
    {
        return 0;
    }
}
