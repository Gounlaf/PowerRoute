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
    public function createFromConfig(array $config, Executor $executor)
    {
        $actions = [];

        foreach ($config as $actionData) {
            $action = key($actionData);
            $this->checkMappingIsValid($action);
            $class = $this->mapping[$action];
            $actions[] = new $class($this->getConstructorArgument($executor, $actionData[$action], $class));
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
