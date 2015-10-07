<?php
namespace Mcustiel\PowerRoute\Common;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     */
    public function start(ServerRequestInterface $request, ResponseInterface $response)
    {
        $transactionData = new TransactionData($request, $response);
        return $this->execute($this->config['start'], $transactionData);
    }

    /**
     * @param string                                  $routeName
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function execute($routeName, TransactionData $transactionData)
    {
        $route = $this->config['routes'][$routeName];

        $actions = $this->actionFactory->createFromConfig(
            $this->getActionsToRun($route, $this->evaluateCondition($route, $transactionData->getRequest())),
            $this
        );

        foreach ($actions as $action) {
            $action->execute($transactionData);
        }

        return $transactionData->getResponse();
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
