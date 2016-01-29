<?php
namespace Mcustiel\PowerRoute\Common\Factories;

use Mcustiel\PowerRoute\Actions\GoToAction;
use Mcustiel\PowerRoute\PowerRoute;
use Mcustiel\PowerRoute\Actions\ActionInterface;

class ActionFactory extends Mapping
{
    public function __construct(array $mapping)
    {
        parent::__construct(array_merge(['goto' => [GoToAction::class]], $mapping));
    }

    /**
     * @param array $config
     *
     * @return \Mcustiel\PowerRoute\Actions\ActionInterface[]
     */
    public function createFromConfig(array $config, PowerRoute $executor)
    {
        $actions = [];

        foreach ($config as $actionData) {
            $actions[] = $this->createActionFromConfig($actionData, $executor);
        }

        return $actions;
    }

    private function createActionFromConfig($actionData, $executor)
    {
        $class = key($actionData);
        $this->checkMappingIsValid($class);

        if (is_object($this->mapping[$class])) {
            return $this->mapping[$class];
        }

        $className = $this->getClassName($class);
        $arguments = $this->getConstructorArguments($class);

        $object = new $className($arguments);
        $object->setArgument(
            $this->getConstructorArgument($executor, $actionData[$class], $className)
        );

        return $object;
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
