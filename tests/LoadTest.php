<?php
use Lucid\Component\Factory\Factory;

class LoadTest extends \PHPUnit_Framework_TestCase
{
    public $factory = null;
    public function setup()
    {
        $config = new \Lucid\Component\Container\Container();
        $config->set('root', realpath(__DIR__.'/app/'));
        $this->factory = new Factory(null, $config);
    }

    public function testLoad()
    {
        $model = $this->factory->model('Test1');
        $this->assertEquals('ORMWrapper', get_class($model));

        $view = $this->factory->view('Test1');
        $this->assertEquals('App\\View\\Test1', get_class($view));

        $controller = $this->factory->controller('Test1');
        $this->assertEquals('App\\Controller\\Test1', get_class($controller));

        $ruleset = $this->factory->ruleset('Test1');
        $this->assertEquals('App\\Ruleset\\Test1', get_class($ruleset));

        $helper = $this->factory->helper('Test1');
        $this->assertEquals('App\\Helper\\Test1', get_class($helper));
    }

    public function testLoadFromView()
    {
        $view = $this->factory->view('Test1');

        $controller = $view->controller();
        $this->assertEquals('App\\Controller\\Test1', get_class($controller));

        $ruleset = $view->ruleset();
        $this->assertEquals('App\\Ruleset\\Test1', get_class($ruleset));

        $helper = $view->helper();
        $this->assertEquals('App\\Helper\\Test1', get_class($helper));
    }

    public function testLoadFromController()
    {
        $controller = $this->factory->controller('Test1');

        $model = $controller->model();
        $this->assertEquals('ORMWrapper', get_class($model));

        $view = $controller->view();
        $this->assertEquals('App\\View\\Test1', get_class($view));

        $ruleset = $controller->ruleset();
        $this->assertEquals('App\\Ruleset\\Test1', get_class($ruleset));

        $helper = $controller->helper();
        $this->assertEquals('App\\Helper\\Test1', get_class($helper));
    }

    public function testLoadFromRuleset()
    {
        $ruleset = $this->factory->ruleset('Test1');

        $model = $ruleset->model();
        $this->assertEquals('ORMWrapper', get_class($model));

        $view = $ruleset->view();
        $this->assertEquals('App\\View\\Test1', get_class($view));

        $controller = $ruleset->controller();
        $this->assertEquals('App\\Controller\\Test1', get_class($controller));

        $helper = $ruleset->helper();
        $this->assertEquals('App\\Helper\\Test1', get_class($helper));
    }

    public function testLoadFromHelper()
    {
        $helper = $this->factory->helper('Test1');

        $model = $helper->model();
        $this->assertEquals('ORMWrapper', get_class($model));

        $view = $helper->view();
        $this->assertEquals('App\\View\\Test1', get_class($view));

        $controller = $helper->controller();
        $this->assertEquals('App\\Controller\\Test1', get_class($controller));

        $ruleset = $helper->ruleset();
        $this->assertEquals('App\\Ruleset\\Test1', get_class($ruleset));
    }
}