<?php namespace XType\Factory;

interface FactoryInterface{

    /**
     * Returns if this factory can create a type by config $config
     *
     * @param mixed $config
     * @return bool
     **/
    public function canCreate($config);

    /**
     * Creates a type by config $config
     *
     * @param mixed $config
     * @return \XType\AbstractType
     **/
    public function create($config);

}