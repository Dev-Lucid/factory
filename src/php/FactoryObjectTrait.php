<?php
namespace Lucid\Component\Factory;

Trait FactoryObjectTrait
{
    protected $factory = null;

    public function setFactory($factory)
    {
        $this->factory = $factory;
    }

    public function model()
    {
        return $this->factory->model((new \ReflectionClass($this))->getShortName());
    }

    public function view()
    {
        return $this->factory->view((new \ReflectionClass($this))->getShortName());
    }

    public function controller()
    {
        return $this->factory->controller((new \ReflectionClass($this))->getShortName());
    }

    public function ruleset()
    {
        return $this->factory->ruleset((new \ReflectionClass($this))->getShortName());
    }

    public function helper()
    {
        return $this->factory->helper((new \ReflectionClass($this))->getShortName());
    }
}
