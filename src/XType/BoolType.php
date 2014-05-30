<?php namespace XType;

class BoolType extends AbstractType{

    protected $defaultValue = FALSE;

    protected $trueString = NULL;

    protected $falseString = NULL;

    public static $defaultTrueString = 'true';

    public static $defaultFalseString = 'false';

    public function getGroup(){
        return self::BOOL;
    }

    public function valueToString($value){
        if($this->castToBool($value)){
            return $this->getTrueString();
        }
        return $this->getFalseString();
    }

    public function getTrueString(){
        if($this->trueString !== NULL){
            return $this->trueString;
        }
        return static::$defaultTrueString;
    }

    public function setTrueString($trueString){
        $this->trueString = $trueString;
        return $this;
    }

    public function getFalseString(){
        if($this->falseString !== NULL){
            return $this->falseString;
        }
        return static::$defaultFalseString;
    }

    public function setFalseString($falseString){
        $this->falseString = $falseString;
        return $this;
    }

    public function castToBool($value){
        if(is_int($value) || is_float($value) || is_double($value)){
            return (bool)$value;
        }
        if(is_string($value)){
            if(in_array(mb_strtolower($value), array('no','false','0'))){
                return FALSE;
            }
            return TRUE;
        }
        if($value){
            return TRUE;
        }
        return FALSE;
    }

}