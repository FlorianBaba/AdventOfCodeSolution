<?php
require_once __DIR__.'/Ingredient.php';

/**
 * @author: FlorianBaba
 * Date: 05/01/16
 */
class RecipeCalculator
{
    const NB_MAX_OF_SPOON = 100;
    const GOAL_NB_OF_CALORIES = 500;
    const PART_ONE = 1;
    const PART_TWO = 2;

    /**
     * @var int
     */
    private $part;

    /**
     * @var int
     */
    private $maxPoints;

    /**
     * @var array
     */
    private $nbSpoonByIngredient;

    /**
     * @var Ingredient[]
     */
    private $ingredientList;

    /**
     * @param Ingredient[] $ingredientList
     * @param int $part
     */
    public function __construct(array $ingredientList, $part)
    {
        $this->ingredientList = $ingredientList;
        $this->part = $part;
        $this->maxPoints = 0;
        $this->nbSpoonByIngredient = array();
        foreach ($this->ingredientList as $key => $ingredient) {
            $this->nbSpoonByIngredient[$key] = 0;
        }
    }

    /**
     * @return int
     */
    public function getPointsOfOptimalRecipe()
    {
        $this->calculateOptimalRecipeRecursive(0);

        return $this->maxPoints;
    }

    /**
     * @param int $key
     */
    private function calculateOptimalRecipeRecursive($key)
    {
        for ($i = 0; $i <= self::NB_MAX_OF_SPOON; $i++) {
            $this->nbSpoonByIngredient[$key] = $i;

            if (isset($this->nbSpoonByIngredient[$key + 1])) {
                $this->calculateOptimalRecipeRecursive($key + 1);
            } elseif (array_sum($this->nbSpoonByIngredient) === self::NB_MAX_OF_SPOON) {
                $this->calculatePoints();
            }
        }
    }

    private function calculatePoints()
    {
        $properties = array(
            'capacity' => 0,
            'durability' => 0,
            'flavor' => 0,
            'texture' => 0,
            'calories' => 0,
        );

        // cumulate totals of each properties
        foreach ($this->ingredientList as $key => $ingredient) {
            $properties['capacity'] += ($ingredient->getCapacity() * $this->nbSpoonByIngredient[$key]);
            $properties['durability'] += ($ingredient->getDurability() * $this->nbSpoonByIngredient[$key]);
            $properties['flavor'] += ($ingredient->getFlavor() * $this->nbSpoonByIngredient[$key]);
            $properties['texture'] += ($ingredient->getTexture() * $this->nbSpoonByIngredient[$key]);
            $properties['calories'] += ($ingredient->getCalories() * $this->nbSpoonByIngredient[$key]);
        }


        // negative totals become 0
        foreach ($properties as $key => $property) {
            if ($property < 0) {
                $properties[$key] = 0;
            }
        }

        // calculate points
        $points = $properties['capacity'] * $properties['durability'] * $properties['flavor'] * $properties['texture'];

        if ($points > $this->maxPoints) {
            if ($this->part === self::PART_ONE || $properties['calories'] === 500) {
                $this->maxPoints = $points;
            }
        }
    }
}
