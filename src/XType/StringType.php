<?php namespace XType;

class StringType extends AbstractType
{

    protected $defaultValue = '';

    protected $minLength = 0;

    protected $maxLength = 10000000;

    public function getGroup(){
        return self::STRING;
    }

    public function valueToString($value){
        return "$value";
    }

    public function getMinLength(){
        return $this->minLength;
    }

    public function setMinLength($minLength){
        $this->minLength = $minLength;
        return $this;
    }

    public function getMaxLength(){
        return $this->maxLength;
    }

    public function setMaxLength($maxLength){
        $this->maxLength = $maxLength;
        return $this;
    }

}