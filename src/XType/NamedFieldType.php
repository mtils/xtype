<?php namespace XType;

use \DateTime;
use \IteratorAggregate;
use \ArrayAccess;
use \BadMethodCallException;
use \Countable;
use \ArrayIterator;
use \OutOfBoundsException;

class NamedFieldType extends AbstractType implements ArrayAccess, IteratorAggregate, Countable
{

    protected $defaultValue = array();

    protected $namedTypes = array();

    public function getGroup(){
        return self::COMPLEX;
    }

    public function getKeys(){
        return array_keys($this->namedTypes);
    }

    public function offsetGet($offset){
        return $this->namedTypes[$offset];
    }

    public function get($name){
        if(!$this->offsetExists($name)){
            throw new OutOfBoundsException("Key '$name' not found");
        }
        return $this->offsetGet($name);
    }

    public function set($name, AbstractType $type){
        $this->offsetSet($name, $type);
        return $this;
    }

    public function offsetSet($offset, $type){
        if(!$type instanceof AbstractType){
            throw new BadMethodCallException('You can only add AbstractType instances');
        }
        $this->namedTypes[$offset] = $type;
    }

    public function offsetExists($offset){
        return isset($this->namedTypes[$offset]);
    }

    public function offsetUnset($offset){
        unset($this->namedTypes[$offset]);
    }

    public function count(){
        return count($this->namedTypes);
    }

    public function getIterator(){
        return new ArrayIterator($this->namedTypes);
    }

    public function valueToString($value){
        $string = "";
        foreach($this as $key=>$type){
            if(isset($value[$key])){
                $string .= "\n$key " . $type->valueToString($value[$key]);
            }
        }
        return $string;
    }
}