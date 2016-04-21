<?php
namespace Lucid\Component\Factory;

# extends \Lucid\Component\Ruleset\Ruleset 
abstract class Ruleset implements RulesetInterface, FactoryObjectInterface
{
    use FactoryObjectTrait;
}
