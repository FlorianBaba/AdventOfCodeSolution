<?php

require_once __DIR__.'/../lib/AbstractScriptDay.php';
require_once __DIR__.'/DeliverRouteFactory.php';

/**
 * @author: FlorianBaba
 * Date: 13/12/15
 */
class ScriptDay9 extends AbstractScriptDay
{
    /**
     * @var array
     */
    private $distanceBetweenCities;

    /**
     * @var DeliverRouteFactory
     */
    private $deliverRouteFactory;

    public function __construct()
    {
        parent::__construct();
        $this->deliverRouteFactory = null;
        $this->distanceBetweenCities = null;
    }

    /**
     * {@inheritdoc}
     */
    protected function getAnswer($part)
    {
        if (empty($this->distanceBetweenCities)) {
            $this->loadDistanceBetweenCities();
        }

        if (empty($this->deliverRouteFactory)) {
            $this->deliverRouteFactory = new DeliverRouteFactory($this->distanceBetweenCities);
        }

        $routes = array();
        foreach ($this->distanceBetweenCities as $fromCity => $toCities) {
            $deliverRoute = $this->deliverRouteFactory->build($fromCity, $part);
            $routes[$deliverRoute->getRoute()] = $deliverRoute->getTotalDistance();
        }

        if ($part === 1) {
            $answer = 'The shortest distance is : '.min($routes);
        } else {
            $answer = 'The longest distance is : '.max($routes);
        }

        return $answer;
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return 'Day 9';
    }

    /**
     * {@inheritdoc}
     */
    protected function getInstructionsFilePath()
    {
        return __DIR__.'/instructions.txt';
    }

    private function loadDistanceBetweenCities()
    {
        $distanceBetweenCities = array();

        while ($instruction = $this->getNextInstruction()) {
            list($cities, $distance) = explode(' = ', $instruction);
            list($city1, $city2) = explode(' to ', $cities);
            $distance = (int)$distance;
            $distanceBetweenCities[$city1][$city2] = $distance;
            $distanceBetweenCities[$city2][$city1] = $distance;
        }

        $this->distanceBetweenCities = $distanceBetweenCities;
    }
}
