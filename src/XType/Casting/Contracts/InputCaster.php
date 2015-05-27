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

}