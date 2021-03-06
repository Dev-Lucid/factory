<?php
namespace Lucid\Component\Factory;

Interface FactoryObjectInterface
{
    public function setFactory($factory);
    public function model();
    public function view();
    public function controller();
    public function ruleset();
    public function helper();
}
