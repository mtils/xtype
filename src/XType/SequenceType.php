<?php namespace XType;

use \DateTime;
use \IteratorAggregate;
use \ArrayAccess;
use \BadMethodCallException;
use \Countable;
use \ArrayIterator;

class SequenceType extends AbstractType{

    protected $defaultValue = array();

    protected $minItems = 0;

    protected $maxItems = 1000000;

    protected $itemType = NULL;

    public function getGroup(){
        return self::COMPLEX;
    }

    public function getMinItems(){
        return $this->minItems;
    }

    public function setMinItems($minItems){
        $this->minItems = $minItems;
        return $this;
    }

    public function getMaxItems(){
        return $this->maxItems;
    }

    public function setMaxItems($maxItems){
        $this->maxItems = $maxItems;
        return $this;
    }

    public function getItemType(){
        return $this->itemType;
    }

    public function setItemType(AbstractType $type){
        $this->itemType = $type;
        return $this;
    }

    public function valueToString($value){
        $values = array();
        foreach($value as $item){
            $values[] = "$item";
        }
        return implode(',',$values);
    }
}