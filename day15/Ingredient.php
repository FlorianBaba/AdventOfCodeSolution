<?php

/**
 * @author: FlorianBaba
 * Date: 05/01/16
 */
class Ingredient
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $capacity;

    /**
     * @var int
     */
    private $durability;

    /**
     * @var int
     */
    private $flavor;

    /**
     * @var int
     */
    private $texture;

    /**
     * @var int
     */
    private $calories;

    /**
     * @param int $name
     * @param int $capacity
     * @param int $durability
     * @param int $flavor
     * @param int $texture
     * @param int $calories
     */
    public function __construct(
        $name,
        $capacity,
        $durability,
        $flavor,
        $texture,
        $calories
    ) {
        $this->name = $name;
        $this->capacity = $capacity;
        $this->durability = $durability;
        $this->flavor = $flavor;
        $this->texture = $texture;
        $this->calories = $calories;
    }

    /**
     * @return int
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @param int $capacity
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    /**
     * @return int
     */
    public function getDurability()
    {
        return $this->durability;
    }

    /**
     * @param int $durability
     */
    public function setDurability($durability)
    {
        $this->durability = $durability;
    }

    /**
     * @return int
     */
    public function getFlavor()
    {
        return $this->flavor;
    }

    /**
     * @param int $flavor
     */
    public function setFlavor($flavor)
    {
        $this->flavor = $flavor;
    }

    /**
     * @return int
     */
    public function getTexture()
    {
        return $this->texture;
    }

    /**
     * @param int $texture
     */
    public function setTexture($texture)
    {
        $this->texture = $texture;
    }

    /**
     * @return int
     */
    public function getCalories()
    {
        return $this->calories;
    }

    /**
     * @param int $calories
     */
    public function setCalories($calories)
    {
        $this->calories = $calories;
    }
}
