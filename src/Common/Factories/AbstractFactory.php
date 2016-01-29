<?php
namespace Mcustiel\PowerRoute\Common\Factories;

abstract class AbstractFactory extends Mapping
{
    /**
     *
     * @param array $config
     *
     * @return \Mcustiel\PowerRoute\InputSources\InputSourceInterface
     * @throws \Exception
     */
    public function createFromConfig(array $config)
    {
        $class = key($config);
        $this->checkMappingIsValid($class);

        return $this->getInstance($class, $config);
    }

    private function getInstance($class, $config)
    {
        if (is_object($this->mapping[$class])) {
            return $this->mapping[$class];
        }

        return $this->createInstance($this->getClassName($class), $config, $class);
    }

    private function createInstance($className, $config, $class)
    {
        $arguments = $this->getConstructorArguments($class);

        $object = new $className(...$arguments);
        $object->setArgument($config[$class]);

        return $object;
    }
}
