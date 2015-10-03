<?php
namespace Mcustiel\PowerRoute\Common;

use Mcustiel\PowerRoute\Actions as Actions;

class ActionFactory extends Mapping
{
    public function __construct(array $mapping)
    {
        parent::__construct(array_merge(['goto' => Actions\GoToAction::class], $mapping));
    }

    /**
     * @param array|\stdClass $config
     *
     * @return \Mcustiel\PowerRoute\Actions\ActionInterface[]
     */
    public function createFromConfig(array $actionsConfig, RouteExecutor $executor)
    {
        $actions = [];

        foreach ($actionsConfig as $action => $argument) {
            $this->checkMappingIsValid($action);

            $class = $this->mapping[$action];
            $actions[] = new $class($this->getConstructorArgument($executor, $argument, $class));
        }

        return $actions;
    }

    private function getConstructorArgument($executor, $argument, $class)
    {
        if ($class == Actions\GoToAction::class) {
            $classArgument = new \stdClass;
            $classArgument->route = $argument;
            $classArgument->executor = $executor;
        } else {
            $classArgument = $argument;
        }

        return $classArgument;
    }

}
