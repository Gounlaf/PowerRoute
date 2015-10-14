<?php
namespace Mcustiel\PowerRoute\Common;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Executor
{
    const CONFIG_ROOT_NODE = 'start';
    const CONFIG_NODES = 'nodes';
    const CONFIG_NODE_CONDITION = 'condition';
    const CONFIG_NODE_CONDITION_SOURCE = 'input-source';
    const CONFIG_NODE_CONDITION_MATCHER = 'matcher';
    const CONFIG_NODE_CONDITION_ACTIONS = 'actions';
    const CONFIG_NODE_CONDITION_ACTIONS_MATCH = 'if-matches';
    const CONFIG_NODE_CONDITION_ACTIONS_NOTMATCH = 'else';

    /**
     * @var array $config
     */
    private $config;

    /**
     * @var ActionFactory $actionFactory
     */
    private $actionFactory;
    /**
     * @var InputSourceFactory $evaluatorFactory
     */
    private $evaluatorFactory;
    /**
     * @var MatcherFactory $matcherFactory
     */
    private $matcherFactory;

    public function __construct(
        array $config,
        ActionFactory $actionFactory,
        InputSourceFactory $evaluatorFactory,
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
        $this->execute($this->config[static::CONFIG_ROOT_NODE], $transactionData);
        return $transactionData->getResponse();
    }

    /**
     * @param string          $routeName
     * @param TransactionData $transactionData
     */
    public function execute($routeName, TransactionData $transactionData)
    {
        $route = $this->config[static::CONFIG_NODES][$routeName];

        $actions = $this->actionFactory->createFromConfig(
            $this->getActionsToRun($route, $this->evaluateCondition($route, $transactionData->getRequest())),
            $this
        );

        foreach ($actions as $action) {
            $action->execute($transactionData);
        }
    }

    private function evaluateCondition($route, $request)
    {
        if ($route[static::CONFIG_NODE_CONDITION]) {
            $inputSource = $this->evaluatorFactory->createFromConfig(
                $route[static::CONFIG_NODE_CONDITION][static::CONFIG_NODE_CONDITION_SOURCE]
            );
            $matcher = $this->matcherFactory->createFromConfig(
                $route[static::CONFIG_NODE_CONDITION][static::CONFIG_NODE_CONDITION_MATCHER]
            );
            return $matcher->match($inputSource->getValue($request));
        }
        return true;
    }

    private function getActionsToRun($route, $matched)
    {
        if ($matched) {
            return $route[static::CONFIG_NODE_CONDITION_ACTIONS][static::CONFIG_NODE_CONDITION_ACTIONS_MATCH];
        }

        return $route[static::CONFIG_NODE_CONDITION_ACTIONS][static::CONFIG_NODE_CONDITION_ACTIONS_NOTMATCH];
    }
}
