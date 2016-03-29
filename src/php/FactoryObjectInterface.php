<?php
namespace Lucid\Component\Factory;

Interface FactoryObjectInterface
{
    public function setFactory($factory);
    public function model($id=null);
    public function view(...$parameters);
    public function controller(...$parameters);
    public function ruleset(...$parameters);
    public function library(...$parameters);
}
