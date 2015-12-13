<?php

require_once __DIR__.'/DeliverRoute.php';

/**
 * @author: FlorianBaba
 * Date: 13/12/15
 */
class DeliverRouteFactory
{
    /**
     * @var array
     */
    private $distanceBetweenCities;

    /**
     * DeliverRoute constructor.
     * @param $distanceBetweenCities
     */
    public function __construct($distanceBetweenCities)
    {
        $this->distanceBetweenCities = $distanceBetweenCities;
    }

    /**
     * @param string $fromCity
     * @return DeliverRoute
     */
    public function build($fromCity, $part)
    {
        $deliverRoute = new DeliverRoute();

        // route type
        $type = ($part === 1) ? DeliverRoute::ROUTE_TYPE_SHORTEST : DeliverRoute::ROUTE_TYPE_LONGEST;
        $deliverRoute->setType($type);

        // calculation
        $this->calculateRoute($deliverRoute, $fromCity);

        return $deliverRoute;
    }

    /**
     * @param DeliverRoute $deliverRoute
     * @param string $fromCity
     */
    private function calculateRoute(DeliverRoute $deliverRoute, $fromCity)
    {
        $deliverRoute->addUsedCity($fromCity);

        $toCities = array_diff_key(
            $this->distanceBetweenCities[$fromCity],
            array_flip($deliverRoute->getUsedCities())
        );

        if (count($toCities)) {

            // get the shortest OR the longest distance
            if ($deliverRoute->getType() == DeliverRoute::ROUTE_TYPE_SHORTEST) {
                $distance = min($toCities);
            } else {
                $distance = max($toCities);
            }

            $deliverRoute->addDistance($distance);

            // recursive call
            $this->calculateRoute($deliverRoute, array_search($distance, $toCities));
        }
    }
}
