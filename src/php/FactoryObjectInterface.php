<?php
namespace Lucid\Component\Factory;

Interface FactoryObjectInterface
{
    public function setFactory($factory);
    public function model();
    public function view($method='render');
    public function controller();
    public function ruleset();
}
