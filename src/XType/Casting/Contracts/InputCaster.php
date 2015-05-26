<?php namespace XType\Casting;

/**
 *  An InputCaster casts user input to model data in masses. It receives an
 *  array and returns a casted array
 *
 **/
interface InputCaster
{

    /**
     * Return the base model class to which the array should be casted
     *
     * @return string
     **/
    public function modelClass();

    /**
     * Set the base model class to which the array should be casted
     *
     * @param string $class
     * @return self
     **/
    public function setModelClass($class)

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

}