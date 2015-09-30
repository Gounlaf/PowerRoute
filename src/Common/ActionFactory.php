<?php
namespace Mcustiel\PowerRoute\Common;

use Mcustiel\PowerRoute\Actions as Actions;

class ActionFactory
{
    private $mapping = [
        'goto' => Actions\GoToAction::class,
        'redirect' => Actions\RedirectAction::class,
        'notFound' => Actions\NotFoundAction::class,
        'displayFile' => Actions\DisplayFileAction::class
    ];

    public function __construct(array $mapping)
    {
        $this->mapping = array_merge($this->mapping, $mapping);
    }

    /**
     * @param array|\stdClass $config
     *
     * @return \Mcustiel\PowerRoute\Actions\ActionInterface[]
     */
    public function createFromConfig(array $actionsConfig, RouteExecutor $executor)
    {
        $actions = [];

        foreach ($actionsConfig as $actionData) {
            if (!isset($this->mapping[$actionData['action']])) {
                throw new \Exception();
            }
            $class = $this->mapping[$actionData['action']];
            if ($class == Actions\GoToAction::class) {
                $argument = new \stdClass;
                $argument->route = $actionData['argument'];
                $argument->executor = $executor;
            } else {
                $argument = $actionData['argument'];
            }
            $actions[] = new $class($argument);
        }

        return $actions;
    }
}
