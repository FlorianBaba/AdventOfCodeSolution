<?php

/**
 * @author: FlorianBaba
 * Date: 12/12/15
 */
class ScriptDayFactory
{
    /**
     * @param int $day
     * @return AbstractScriptDay
     * @throws ErrorException
     */
    public function build($day)
    {
        $day = (int)$day;
        $className = 'ScriptDay'.$day;
        $directory = 'day'.$day;
        $scriptDayPath = __DIR__.'/../'.$directory.'/'.$className.'.'.'php';

        if (!file_exists($scriptDayPath)) {
            throw new ErrorException(sprintf('There is no script file for day %d', $day));
        }

        require_once($scriptDayPath);

        if (!class_exists($className)) {
            throw new ErrorException(sprintf('There is no script class for day %d', $day));
        }

        return new $className();
    }
}
