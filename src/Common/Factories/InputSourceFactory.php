<?php
namespace Mcustiel\PowerRoute\Common\Factories;

class InputSourceFactory extends Mapping
{
    public function __construct(array $mapping)
    {
        parent::__construct($mapping);
    }

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

        return new $this->mapping[$class]($config[$class]);
    }
}
