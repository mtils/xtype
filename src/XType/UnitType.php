<?php namespace XType;

class UnitType extends NumberType{

    const PREPEND = 1;

    const APPEND = 2;

    protected $defaultValue = 0.0;

    protected $unit = '';

    protected $unitPosition = self::APPEND;

    protected $valueUnitGap = 1;

    protected $maxLength = 10000000;

    public function getGroup(){
        return self::NUMBER;
    }

    public function valueToString($value){
        $valueString = parent::valueToString($value);
        if(!$this->unit){
            return $valueString;
        }
        if($this->unitPosition == self::PREPEND){
            return $this->unit . str_repeat(' ',$this->valueUnitGap) . $valueString;
        }
        return $valueString . str_repeat(' ',$this->valueUnitGap) . $this->unit;
    }

    public function getUnit(){
        return $this->unit;
    }

    public function setUnit($unit){
        $this->unit = $unit;
        return $this;
    }

    public function getUnitPosition(){
        return $this->unitPosition;
    }

    public function setUnitPosition($position){
        $this->unitPosition = $position;
        return $this;
    }

    public function prependUnit(){
        return $this->setUnitPosition(self::PREPEND);
    }

    public function appendUnit(){
        return $this->setUnitPosition(self::APPEND);
    }

    public function getValueUnitGap(){
        return $this->valueUnitGap;
    }

    public function setValueUnitGap($spaces){
        $this->valueUnitGap = $spaces;
        return $this;
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