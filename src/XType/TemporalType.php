<?php namespace XType;

use \DateTime;

class TemporalType extends AbstractType{

    protected $defaultValue = NULL;

    public static $defaultFormat = DateTime::ATOM;

    protected $format = NULL;

    protected $min = NULL;

    protected $max = NULL;

    public function getGroup(){
        return self::TEMPORAL;
    }

    public function getDefaultValue(){
        if($this->defaultValue === NULL){
            return new DateTime();
        }
        return $this->defaultValue;
    }

    public function getMin(){
        return $this->min;
    }

    public function setMin(DateTime $dateTime){
        $this->min = $dateTime;
        return $this;
    }

    public function getMax(){
        return $this->max;
    }

    public function setMax(DateTime $max){
        $this->max = $max;
        return $this;
    }

    public function getFormat(){
        if($this->format !== NULL){
            return $this->format;
        }
        return static::$defaultFormat;
    }

    public function setFormat($format){
        $this->format = $format;
        return $this;
    }

    public function valueToString($value){
        if($value instanceof DateTime){
            $dateTime = $value;
        }
        elseif(is_string($value)){
            $dateTime = new DateTime($value);
        }
        else{
            return "$value";
        }
        return $dateTime->format($this->getFormat());
    }

    public function castToModel($value)
    {
        return DateTime::createFromFormat($this->getFormat(), $value);
    }

}