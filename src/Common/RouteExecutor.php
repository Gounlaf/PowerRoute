<?php
namespace Mcustiel\PowerRoute\Common;

use Mcustiel\PowerRoute\Http\Request;
use Psr\Http\Message\ResponseInterface;

class RouteExecutor
{
    private $config;

    /**
     * @var ActionFactory $actionFactory
     */
    private $actionFactory;
    /**
     * @var EvaluatorFactory $evaluatorFactory
     */
    private $evaluatorFactory;
    /**
     * @var MatcherFactory $matcherFactory
     */
    private $matcherFactory;

    public function __construct(
        array $config,
        ActionFactory $actionFactory,
        EvaluatorFactory $evaluatorFactory,
        MatcherFactory $matcherFactory
    ) {
        $this->config = $config;
        $this->evaluatorFactory = $evaluatorFactory;
        $this->actionFactory = $actionFactory;
        $this->matcherFactory = $matcherFactory;
    }

    public function start(Request $request, ResponseInterface $response)
    {
        $this->execute($this->config['start'], $request, $response);
    }

    public function execute($routeName, Request $request, ResponseInterface $response)
    {
        $route = $this->config['routes'][$routeName];

        $actions = $this->actionFactory->createFromConfig(
            $this->getActionsToRun($route, $this->evaluateCondition($route, $request)),
            $this
        );

        foreach ($actions as $action) {
            $response = $action->execute($request, $response);
        }

        return $response;
    }

    private function evaluateCondition($route, $request)
    {
        if ($route['condition']) {
            $evaluator = $this->evaluatorFactory->createFromConfig($route['condition']['evaluator']);
            $matcher = $this->matcherFactory->createFromConfig($route['condition']['matcher']);
            return $evaluator->evaluate($matcher, $request);
        }
        return true;
    }

    private function getActionsToRun($route, $matched)
    {
        if ($matched) {
            return $route['actions']['match'];
        }

        return $route['actions']['doesNotMatch'];
    }
}
