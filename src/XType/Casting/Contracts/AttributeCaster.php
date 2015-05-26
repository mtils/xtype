<?php namespace XType\Casting\Contracts;

/**
 * An attribute caster knows types of attributes of its model and automatically
 * casts data from user to model and back
 **/
interface AttributeCaster
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
    public function setModelClass($class);

    /**
     * Cast $userValue so that the modelClass can work with it
     *
     * @param string $attribute
     * @param mixed $userValue (string)
     * @return mixed
     **/
    public function toModel($attribute, $userValue);

    /**
     * Cast $modelValue (to string) so the user can work with it
     *
     * @param string $attribute
     * @param mixed $modelValue (string)
     * @return string
     **/
    public function toView($attribute, $modelValue);

}