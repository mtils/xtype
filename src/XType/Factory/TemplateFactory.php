<?php namespace XType\Factory;

use DateTime;

use XType\BoolType;
use XType\NumberType;
use XType\StringType;
use XType\TemporalType;
use XType\SequenceType;
use XType\NamedFieldType;

class TemplateFactory implements FactoryInterface{

    /**
     * Returns if this factory can create a type by config $config
     *
     * @param mixed $config
     * @return bool
     **/
    public function canCreate($config){
        return true;
    }

    /**
     * Creates a type by config $config
     *
     * @param mixed $config
     * @return \XType\AbstractType
     **/
    public function create($config){

        $creator = $this->getCreator($config);

        return $this->callCreator($creator, $config);

    }

    public function createBool($config){
        return BoolType::create()->setDefaultValue($config);
    }

    public function createInt($config){
        return NumberType::create()->setNativeType('int')->setDefaultValue($config);
    }

    public function createFloat($config){
        return NumberType::create()->setNativeType('float')->setDefaultValue($config);
    }

    public function createString($config){
        return StringType::create()->setDefaultValue($config);
    }

    public function createTemporal($config){
        return TemporalType::create()->setDefaultValue($config);
    }

    public function createSequence($config){

        $sequence = SequenceType::create()->setDefaultValue($config);

        if(!count($config)){
            return $sequence;
        }

        $sequence->setItemType($this->create($config[0]));

        return $sequence;
    }

    public function createNamedField($config){

        $field = NamedFieldType::create()->setDefaultValue($config);

        foreach($config as $key=>$template){
            $field->set($key, $this->create($template));
        }

        return $field;
    }

    protected function callCreator($creator, $config){

        if(method_exists($this, $creator)){
            return call_user_func([$this,$creator], $config);
        }

    }

    protected function getCreator($config){

        switch(true){

            case is_bool($config):
                return 'createBool';

            case is_int($config):
                return 'createInt';

            case is_float($config):
                return 'createFloat';

            case is_string($config):
                return 'createString';

            case $config instanceof DateTime:
                return 'createTemporal';

            case $this->isSequence($config):
                return 'createSequence';

            case $this->isNamedField($config):
                return 'createNamedField';
        }

    }

    protected function isSequence($array){

        if(!is_array($array)){
            return false;
        }

        if(!count($array)){
            return true;
        }

        if(isset($array[0])){
            return true;
        }

        return false;
    }

    protected function isNamedField($array){

        if(!is_array($array)){
            return false;
        }

        if(!count($array)){
            return false;
        }

        if(is_string(key($array))){
            return true;
        }

        return false;

    }

}