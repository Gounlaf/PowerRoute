<?php
namespace Mcustiel\PowerRoute;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Mcustiel\PowerRoute\Common\Factories\ActionFactory;
use Mcustiel\PowerRoute\Common\TransactionData;
use JMS\Serializer\Exception\RuntimeException;
use Mcustiel\PowerRoute\Common\Conditions\ConditionsMatcherInterface;
use Mcustiel\PowerRoute\Common\Conditions\ConditionsMatcherFactory;
use Mcustiel\PowerRoute\Common\ConfigOptions;

class PowerRoute
{
    const CONDITIONS_MATCHER_ALL = 'allConditionsMatcher';
    const CONDITIONS_MATCHER_ONE = 'oneConditionsMatcher';

    /**
     * @var array $config
     */
    private $config;
    /**
     * @var \Mcustiel\PowerRoute\Common\Factories\ActionFactory $actionFactory
     */
    private $actionFactory;
    /**
     * @var \Mcustiel\PowerRoute\Common\Conditions\ConditionsMatcherInterface[] $conditionsMatchers
     */
    private $conditionMatchers;
    /**
     * @var \Mcustiel\PowerRoute\Common\Conditions\ConditionsMatcherFactory $conditionMatcherFactory
     */
    private $conditionMatcherFactory;

    public function __construct(
        array $config,
        ActionFactory $actionFactory,
        ConditionsMatcherFactory $conditionsMatcherFactory
    ) {
        $this->conditionMatchers = [];
        $this->config = $config;
        $this->conditionMatcherFactory = $conditionsMatcherFactory;
        $this->actionFactory = $actionFactory;
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
        $this->execute($this->config[ConfigOptions::CONFIG_ROOT_NODE], $transactionData);
        return $transactionData->getResponse();
    }

    /**
     * @param string                             $routeName
     * @param \PowerRoute\Common\TransactionData $transactionData
     */
    public function execute($routeName, TransactionData $transactionData)
    {
        $route = $this->config[ConfigOptions::CONFIG_NODES][$routeName];

        $actions = $this->actionFactory->createFromConfig(
            $this->getActionsToRun(
                $route,
                $this->evaluateConditions($route, $transactionData->getRequest())
            ),
            $this
        );

        foreach ($actions as $action) {
            $action->getInstance()->execute($transactionData, $action->getArgument());
        }
    }

    private function evaluateConditions($route, $request)
    {
        if (!$route[ConfigOptions::CONFIG_NODE_CONDITION]) {
            return true;
        }
        if (isset($route[ConfigOptions::CONFIG_NODE_CONDITION][ConfigOptions::CONFIG_NODE_CONDITION_ALL])) {
            return $this->getConditionsMatcher(self::CONDITIONS_MATCHER_ALL)->matches(
                $route[ConfigOptions::CONFIG_NODE_CONDITION][ConfigOptions::CONFIG_NODE_CONDITION_ALL],
                $request
            );
        }
        if (isset($route[ConfigOptions::CONFIG_NODE_CONDITION][ConfigOptions::CONFIG_NODE_CONDITION_ONE])) {
            return $this->getConditionsMatcher(self::CONDITIONS_MATCHER_ONE)->matches(
                $route[ConfigOptions::CONFIG_NODE_CONDITION][ConfigOptions::CONFIG_NODE_CONDITION_ONE],
                $request
            );
        }

        throw new \RuntimeException('Invalid condition specified for route: ' . $route);
    }

    private function getConditionsMatcher($matcher)
    {
        if (!isset($this->conditionMatchers[$matcher])) {
            $this->conditionMatchers[$matcher] = $this->conditionMatcherFactory->get($matcher);
        }
        return $this->conditionMatchers[$matcher];
    }

    private function getActionsToRun($route, $matched)
    {
        if ($matched) {
            return $route[ConfigOptions::CONFIG_NODE_ACTIONS]
                [ConfigOptions::CONFIG_NODE_ACTIONS_MATCH];
        }

        return $route[ConfigOptions::CONFIG_NODE_ACTIONS]
            [ConfigOptions::CONFIG_NODE_ACTIONS_NOTMATCH];
    }
}
