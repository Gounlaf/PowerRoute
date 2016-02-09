<?php
namespace Mcustiel\PowerRoute\Common\Factories;

use Mcustiel\PowerRoute\Common\Conditions\ClassArgumentObject;

abstract class AbstractFactory extends Mapping
{
    /**
     *
     * @param array $config
     *
     * @return \Mcustiel\PowerRoute\InputSources\InputSourceInterface|\Mcustiel\PowerRoute\InputSources\MatcherInterface
     * @throws \Exception
     */
    public function createFromConfig(array $config)
    {
        $class = key($config);
        $this->checkMappingIsValid($class);

        return new ClassArgumentObject($this->mapping[$class]->getInstance(), $config[$class]);
    }
}
