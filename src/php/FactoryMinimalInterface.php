<?php
namespace Lucid\Component\Factory;

# this interface exists to provide the minimal spec needed for Lucid\Component\Queue\Queue. If one wants
# to use their own factory component, they would only need to implement these 3 methods, rather than the 6
# methods specified by FactoryInterface.

interface FactoryMinimalInterface
{
    public function controller(string $name);
    public function view(string $name, $parameters, $method='render');
    public function buildParameters($object, string $method, $parameters=[]);
}