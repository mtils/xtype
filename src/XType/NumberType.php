<?php namespace XType;

class NumberType extends AbstractType{

    protected $defaultValue = 0;

    protected $nativeType = 'float';

    protected $numberFormat = '';

    protected $prefix = '';

    protected $suffix = '';

    public static $defaultMin = -100000;

    public static $defaultMax = 100000;

    protected $min = NULL;

    protected $max = NULL;

    public static $defaultDecimalsSeparator = '.';

    public static $defaultThousandsSeparator = ',';

    protected $decimalsSeparator = NULL;

    protected $thousandsSeperator = NULL;

    protected $decimalsCount = NULL;

    public function getGroup(){
        return self::NUMBER;
    }

    public function getNativeType(){
        return $this->nativeType;
    }

    public function setNativeType($native){
        $this->nativeType = $native;
        return $this;
    }

    public function getNumberFormat(){
        return $this->numberFormat;
    }

    public function setNumberFormat($format){
        $this->numberFormat = $format;
        return $this;
    }

    public function getPrefix(){
        return $this->prefix;
    }

    public function setPrefix($prefix){
        $this->prefix = $prefix;
        return $this;
    }

    public function getSuffix(){
        return $this->suffix;
    }

    public function setSuffix($suffix){
        $this->suffix = $suffix;
        return $this;
    }

    public function getMin(){
        if($this->min !== NULL){
            return $this->min;
        }
        return static::$defaultMin;
    }

    public function setMin($min){
        $this->min = $min;
        return $this;
    }

    public function getMax(){
        if($this->max !== NULL){
            return $this->max;
        }
        return static::$defaultMax;
    }

    public function setMax($max){
        $this->max = $max;
        return $this;
    }

    public function getDecimalsSeparator(){
        if($this->decimalsSeparator !== NULL){
            return $this->decimalsSeparator;
        }
        return static::$defaultDecimalsSeparator;
    }

    public function setDecimalsSeparator($separator){
        $this->decimalsSeparator = $separator;
        return $this;
    }

    public function getThousandsSeparator(){
        if($this->thousandsSeperator !== NULL){
            return $this->thousandsSeperator;
        }
        return static::$defaultThousandsSeparator;
    }

    public function setThousandsSeparator($separator){
        $this->thousandsSeperator = $separator;
    }

    public function getDecimalsCount(){
        if($this->decimalsCount !== NULL){
            return $this->decimalsCount;
        }
        if($this->nativeType  == 'int'){
            return 0;
        }
        return 2;
    }

    public function setDecimalsCount($count){
        $this->decimalsCount = $count;
        return $this;
    }

    public function valueToString($value){
        $formatted = number_format(
            (float)$value,
            $this->getDecimalsCount(),
            $this->getDecimalsSeparator(),
            $this->getThousandsSeparator()
        );
        return "{$this->prefix}$formatted{$this->suffix}";
    }

}