<?php namespace XType\Casting;

/**
  * A Caster casts data between the model (application) and the user
  * This should be on an atomic level like Datetime, Phone Numbers,
  * adding units to amounts. This is not meant to be a template enginge...
  **/
interface Caster
{

    /**
     * Cast some value from user input to model data
     * e.g. '08/20/2014' => \DateTime
     *
     * @param mixed (string)
     * @return mixed
     **/
    public function toModel($userdata);

    /**
     * Cast some value suitable to show it to a user
     * e.g. DateTime => '20.05.2015'
     *
     * @param mixed $modelData
     * @return string
     **/
    public function toView($modelData);

}