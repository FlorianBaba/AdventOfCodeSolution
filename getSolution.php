<?php

/**
 * @author: FlorianBaba
 * Date: 12/12/15
 */
require_once(__DIR__.'/lib/ScriptDayFactory.php');

echo '-----------------------------------------------------'.PHP_EOL;
echo '- My solution for adventofcode.com . by FlorianBaba -'.PHP_EOL;
echo '-----------------------------------------------------'.PHP_EOL.PHP_EOL;

if (empty($_SERVER['argv'][1])) {
    echo 'Error : Can\'t launch the script without a day'.PHP_EOL;
    echo 'Please enter a day as a first parameter'.PHP_EOL;
} else {
    $day = (int)filter_var($_SERVER['argv'][1], FILTER_SANITIZE_NUMBER_INT);
    $scriptDayFactory = new ScriptDayFactory();
    $scriptDay = $scriptDayFactory->build($day);
    echo $scriptDay->getSolution();
}
