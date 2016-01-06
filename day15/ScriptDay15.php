<?php

require_once __DIR__.'/../lib/AbstractScriptDay.php';
require_once __DIR__.'/Ingredient.php';
require_once __DIR__.'/RecipeCalculator.php';

/**
 * @author: FlorianBaba
 * Date: 05/01/16
 */
class ScriptDay15 extends AbstractScriptDay
{
    /**
     * {@inheritdoc}
     */
    protected function getAnswer($part)
    {
        $ingredientList = array();

        while ($instruction = $this->getNextInstruction()) {
            $pattern = '#^(?P<name>\w+): capacity (?<capacity>-?\d*\.{0,1}\d+), durability (?<durability>-?\d*\.{0,1}\d+), flavor (?<flavor>-?\d*\.{0,1}\d+), texture (?<texture>-?\d*\.{0,1}\d+), calories (?<calories>\d+)$#';
            preg_match($pattern, $instruction, $matches);

            if (!isset($matches['name'])) {
                throw new ErrorException(sprintf('Unexpected instruction : %s', $instruction));
            }
            $ingredientList[] = new Ingredient(
                $matches['name'],
                $matches['capacity'],
                $matches['durability'],
                $matches['flavor'],
                $matches['texture'],
                $matches['calories']
            );
        }

        $recipeCalculator = new RecipeCalculator($ingredientList, $part);

        return 'The maximum score for the cookie recipe is '.$recipeCalculator->getPointsOfOptimalRecipe();
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return 'Day 15';
    }

    /**
     * {@inheritdoc}
     */
    protected function getInstructionsFilePath()
    {
        return __DIR__.'/instructions.txt';
    }
}
