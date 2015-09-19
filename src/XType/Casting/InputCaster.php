<?php


namespace XType\Casting;

use XType\Casting\Contracts\InputCaster as InputCasterContract;


class InputCaster implements InputCasterContract
{

    /**
     * @var array
     **/
    protected $chain = [];

    /**
     * @var array
     **/
    protected $casters = [];

    /**
     * @param array $casters
     **/
    public function __construct(array $casters=[])
    {
        $this->casters = $casters;
    }

    /**
     * {@inheritdoc}
     *
     * @param array $input
     * @param array $metadata (optional)
     * @return array
     **/
    public function castInput(array $input, array $metadata=[])
    {

        $casted = $input;

        foreach ($this->chain as $casterName) {
            $result = call_user_func($this->casters[$casterName], $casted);
            $casted = &$result;
        }

        return $casted;

    }

    /**
     * {@inheritdoc}
     *
     * @return array
     **/
    public function chain()
    {
        return $this->chain;
    }

    /**
     * {@inheritdoc}
     *
     * @param string|array $chain
     * @return self (same instance)
     **/
    public function setChain($chain)
    {
        $this->chain = is_string($chain) ? explode('|', $chain) : $chain;
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param string|array $caster
     * @return self (New instance)
     **/
    public function with($caster)
    {

        $newChain = func_num_args() > 1 ? func_get_args() : $caster;

        if (is_string($newChain)) {
            $newChain = explode('|', $newChain);
        }

        $thisChain = $this->chain;

        foreach ($newChain as $name) {

            list($operator, $key) = $this->splitExpression($name);

            if ($operator != '!' && !in_array($key, $thisChain)) {
                $thisChain[] = $key;
                continue;
            }

            if (($idx = array_search($key, $thisChain)) !== false) {
                unset($thisChain[$idx]);
                $thisChain = array_values($thisChain);
            }
        }

        $newInstance = new static($this->casters);
        $newInstance->setChain($thisChain);
        return $newInstance;

    }

    /**
     * {@inheritdoc}
     *
     * @param string $name
     * @param callable $caster
     * @return self (same instance)
     **/
    public function add($name, callable $caster)
    {
        $this->casters[$name] = $caster;
        return $this;
    }

    protected function splitExpression($name)
    {
        if (strpos($name, '!') === 0) {
            return ['!', ltrim($name, '!')];
        }

        return ['+', $name];
    }

}