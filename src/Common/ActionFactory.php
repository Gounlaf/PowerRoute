<?php
namespace Mcustiel\PowerRoute\Common;

use Mcustiel\PowerRoute\Actions\GoToAction;

class ActionFactory extends Mapping
{
    public function __construct(array $mapping)
    {
        parent::__construct(array_merge(['goto' => GoToAction::class], $mapping));
    }

    /**
     * @param array $config
     *
     * @return \Mcustiel\PowerRoute\Actions\ActionInterface[]
     */
    public function createFromConfig(array $config, RouteExecutor $executor)
    {
        $actions = [];

        foreach ($config as $actionConfig) {
            $className = key($actionConfig);
            $this->checkMappingIsValid($className);

            $class = $this->mapping[$className];
            $actions[] = new $class($this->getConstructorArgument($executor, $actionConfig[$className], $class));
        }

        return $actions;
    }

    private function getConstructorArgument($executor, $argument, $class)
    {
        if ($class == GoToAction::class) {
            $classArgument = new \stdClass;
            $classArgument->route = $argument;
            $classArgument->executor = $executor;
        } else {
            $classArgument = $argument;
        }

        return $classArgument;
    }
}
