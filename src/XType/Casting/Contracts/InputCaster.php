<?php namespace XType\Casting\Contracts;

/**
 *  An InputCaster casts user input to model data in masses. It receives an
 *  array and returns a casted array
 *
 **/
interface InputCaster
{

    /**
     * Cast the data of input to a casted array
     * Mainly to use with request objects. If you use it as a request caster
     * you would pass the headers as metadata
     *
     * @param array $input
     * @param array $metadata (optional)
     * @return array
     **/
    public function castInput(array $input, array $metadata=[]);

    /**
     * Returns the default chain e.g. ['no_tokens','no_method']
     *
     * @return array
     **/
    public function chain();

    /**
     * Set the default chain. You can pass a |-separated string or an array.
     * Returns itself, not a new instance
     *
     * @param string|array $chain
     * @return self (same instance)
     **/
    public function setChain($chain);

    /**
     * Return a new instance with the passed castername. Pass multiple arguments or
     * an array to pass multiple casternames. The casternames will be merged
     * with the chain() casters. If you add a leading ! the passed caster will
     * be ommited (removed from chain before the new instance is created)
     *
     * @param string|array $caster
     * @return self (New instance)
     **/
    public function with($caster);

    /**
     * Add a caster with name $name
     *
     * @param string $name
     * @param callable $caster
     * @return self (same instance)
     **/
    public function add($name, callable $caster);

}