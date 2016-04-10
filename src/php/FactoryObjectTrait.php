<?php
namespace Lucid\Component\Factory;

Trait FactoryObjectTrait
{
    protected $factory = null;

    public function setFactory($factory)
    {
        $this->factory = $factory;
    }

    public function model($id=null)
    {
        $object = $this->factory->model((new \ReflectionClass($this))->getShortName());
        if (is_null($id) === false) {
            return $object->find_one($id);
        }
        return $object;
    }

    protected function _callMethodIfPassed($type, ...$parameters) {
        $object = $this->factory->$type((new \ReflectionClass($this))->getShortName());
        if (count($parameters) > 0) {
            $method = array_shift($parameters);
            return $object->$method(...$parameters);
        }
        return $object;
    }

    public function view(...$parameters)
    {
        return $this->_callMethodIfPassed('view', ...$parameters);
    }

    public function controller(...$parameters)
    {
        return $this->_callMethodIfPassed('controller', ...$parameters);
    }

    public function ruleset(...$parameters)
    {
        return $this->_callMethodIfPassed('ruleset', ...$parameters);
    }

    public function helper(...$parameters)
    {
        return $this->_callMethodIfPassed('helper', ...$parameters);
    }
}
