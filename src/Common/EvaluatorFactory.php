<?php
namespace Mcustiel\PowerRoute\Common;

class EvaluatorFactory extends Mapping
{
    public function __construct(array $mapping)
    {
        parent::__construct($mapping);
    }

    /**
     *
     * @param array $config
     *
     * @return \Mcustiel\PowerRoute\Evaluators\EvaluatorInterface
     * @throws \Exception
     */
    public function createFromConfig(array $config)
    {
        $class = key($config);
        $this->checkMappingIsValid($class);

        return new $this->mapping[$class]($config[$class]);
    }
}
