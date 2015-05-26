<?php namespace XType\Casting\Contracts;

/**
 * A CasterProvider is a central place to store the casters
 **/
interface CasterProvider
{

    /**
     * Returns the caster for $attribute of $modelClass
     *
     * @param string $modelClass
     * @param string $attribute
     * @return \XType\Casting\Contracts\Caster
     **/
    public function caster($modelClass, $attribute);

}