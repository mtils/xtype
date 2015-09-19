<?php namespace XType;

abstract class AbstractType{

    const CUSTOM = 1;
    const NUMBER = 2;
    const STRING = 3;
    const BOOL = 4;
    const COMPLEX = 5;
    const TEMPORAL = 6;
    const MIXED = 7;

    /**
     * @brief This value can be null (like NOT NULL in databases)
     * @var bool
     **/
    protected $canBeNull = TRUE;

    protected $defaultValue = NULL;

    protected $forceInteraction = FALSE;

    public abstract function getGroup();

    public abstract function valueToString($value);

    public function getCanBeNull(){
        return $this->canBeNull;
    }

    public function setCanBeNull($canBeNull){
        $this->canBeNull = $canBeNull;
        return $this;
    }

    public function getDefaultValue(){
        return $this->defaultValue;
    }

    public function setDefaultValue($defaultValue){
        $this->defaultValue = $defaultValue;
        return $this;
    }

    public function getForceInteraction(){
        return $this->forceInteraction;
    }

    public function setForceInteraction($force){
        $this->forceInteraction = $force;
        return $this;
    }

    public function __get($name){
        $methodName = "get$name";
        return $this->{$methodName};
    }

    public static function create(){
        $class = get_called_class();
        return new $class;
    }

    /**
     * @brief Use it as a callable for all use cases where you can put a callable
     *        into a formatter
     *
     * @see self::valueToString()
     * @param mixed $value
     * @return string
     **/
    public function __invoke($value){
        return $this->valueToString($value);
    }

    public function castToView($value)
    {
        return $this->valueToString($value);
    }

    public function castToModel($value)
    {
        return $value;
    }
}