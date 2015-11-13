<?php
namespace Mcustiel\PowerRoute;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Mcustiel\PowerRoute\Common\MatcherFactory;
use Mcustiel\PowerRoute\Common\InputSourceFactory;
use Mcustiel\PowerRoute\Common\ActionFactory;
use Mcustiel\PowerRoute\Common\TransactionData;

class PowerRoute
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
     * @var \PowerRoute\Common\ActionFactory $actionFactory
     */
    private $actionFactory;
    /**
     * @var \PowerRoute\Common\InputSourceFactory $evaluatorFactory
     */
    private $evaluatorFactory;
    /**
     * @var \PowerRoute\Common\MatcherFactory $matcherFactory
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

    public function setConfig(array $config)
    {
        $this->config = $config;
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
     * @param string                             $routeName
     * @param \PowerRoute\Common\TransactionData $transactionData
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
            foreach ($route[static::CONFIG_NODE_CONDITION] as $condition) {
                $inputSource = $this->evaluatorFactory->createFromConfig(
                    $condition[static::CONFIG_NODE_CONDITION_SOURCE]
                );
                $matcher = $this->matcherFactory->createFromConfig(
                    $condition[static::CONFIG_NODE_CONDITION_MATCHER]
                );
                if (!$matcher->match($inputSource->getValue($request))) {
                    return false;
                }
            }
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
