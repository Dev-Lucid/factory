<?php
namespace Lucid\Component\Factory;

class Factory implements FactoryInterface, FactoryMinimalInterface
{
    public $path = __DIR__.'/../../../../../app/';
    public $logger = null;

    public function __construct($logger = null)
    {
        if (is_null($logger)) {
            $this->logger = new \Lucid\Component\BasicLogger\BasicLogger();
        } else {
            if (is_object($logger) === false || in_array('Psr\\Log\\LoggerInterface', class_implements($logger)) === false) {
                throw new \Exception('Factory contructor parameter $logger must either be null, or implement Psr\\Log\\LoggerInterface. If null is passed, then an instance of Lucid\\Component\\BasicLogger\\BasicLogger will be instantiated instead, and all messages will be passed along to error_log();');
            }
            $this->logger = $logger;
        }
    }

    public function model(string $name, $id)
    {
        $className = $this->loadClass(__FUNCTION__, $name);
        if (is_null($id) === true) {
            return \Model::factory($name);
        } else {
            if ($id == 0) {
                return \Model::factory($name)->create();
            } else {
                return \Model::factory($name)->find_one($id);
            }
        }
    }

    public function controller(string $name)
    {
        return $this->packageObject(__FUNCTION__, $name);
    }

    public function view(string $name, $parameters)
    {
        $object =  $this->packageObject(__FUNCTION__, $name);
        $boundParameters = $this->buildParameters($object, 'render', $parameters);
        return call_user_func([$object, 'render'], $parameters);
    }

    public function ruleset(string $name)
    {
        return $this->packageObject(__FUNCTION__, $name);
    }

    public function library(string $name)
    {
        return $this->packageObject(__FUNCTION__, $name);
    }

    public function __call($type, $parameters)
    {
        return $this->packageObject($type, $parameters[0]);
    }

    protected function packageObject(string $type, string $name)
    {
        $className = $this->loadClass($type, $name);
        $object = new $className();
        return $object;
    }

    protected function loadClass(string $type, string $name)
    {
        $class = 'App\\'.$type.'\\'.$name;
        if (class_exists($class) === false) {
            $file = $this->path.'/'.$type.'/'.$name.'.php';
            if (file_exists($file) === false) {
                throw new \Exception('Could not find file for class '.$class.'. Should be '.$file);
            }
            include($file);
        }

        if (class_exists($class) === false) {
            throw new \Exception('Loaded correctly named file for class '.$class.', but class did not exist after the file was included.');
        }

        return $class;
    }

    public function buildParameters($object, string $method, $parameters=[])
    {
        $objectClass = get_class($object);

        # we need to use the Request object's methods for casting parameters
        if(is_array($parameters) === true) {
            $parameters = new \Lucid\Component\Store\Store($parameters);
        }

        if (method_exists($objectClass, $method) === false) {
            throw new \Exception($objectClass.' does not contain a method named '.$method.'. Valid methods are: '.implode(', ', get_class_methods($objectClass)));
        }

        $r = new \ReflectionMethod($objectClass, $method);
        $methodParameters = $r->getParameters();

        # construct an array of parameters in the right order using the passed parameters
        $boundParameters = [];
        foreach ($methodParameters as $methodParameter) {
            $type = strval($methodParameter->getType());
            if ($parameters->is_set($methodParameter->name)) {
                if (is_null($type) === true || $type == '' || method_exists($parameters, $type) === false) {
                    $boundParameters[] = $parameters->raw($methodParameter->name);
                } else {
                    $boundParameters[] = $parameters->$type($methodParameter->name);
                }
            } else {
                if ($methodParameter->isDefaultValueAvailable() === true) {
                    $boundParameters[] = $methodParameter->getDefaultValue();
                } else {
                    throw new \Exception('Could not find a value to set for parameter '.$methodParameter->name.' of function '.$thisClass.'->'.$method.', and no default value was set.');
                }
            }
        }
        return $boundParameters;
    }
}