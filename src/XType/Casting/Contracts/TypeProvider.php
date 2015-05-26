<?php namespace XType\Casting\Contracts;

/**
 * A TypeProvider is a central place to store the types
 **/
interface TypeProvider
{
    /**
     * Returns an object describing the type of $attribute of $modelClass
     *
     * @param string $modelClass
     * @param string $attribute
     * @return \XType\AbstractType
     **/
    public function type($modelClass, $attribute);

}