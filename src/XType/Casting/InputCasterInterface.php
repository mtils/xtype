<?php namespace XType\Casting;

interface InputCasterInterface
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