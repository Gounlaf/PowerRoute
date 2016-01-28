<?php
namespace Mcustiel\PowerRoute\Common\Conditions;

use Mcustiel\PowerRoute\Common\InputSourceFactory;
use Mcustiel\PowerRoute\Common\MatcherFactory;
use Mcustiel\PowerRoute\PowerRoute;
use Mcustiel\PowerRoute\Common\ConfigOptions;

abstract class AbstractConditionsMatcher
{
    private $inputSouceFactory;
    private $matcherFactory;

    public function __construct(
        InputSourceFactory $inputSouceFactory,
        MatcherFactory $matcherFactory
    ) {
        $this->inputSouceFactory = $inputSouceFactory;
        $this->matcherFactory = $matcherFactory;
    }

    protected function getInputSource(array $condition)
    {
        return $this->inputSouceFactory->createFromConfig(
            $condition[ConfigOptions::CONFIG_NODE_CONDITION_SOURCE]
        );
    }

    protected function getMatcher(array $condition)
    {
        return $this->matcherFactory->createFromConfig(
            $condition[ConfigOptions::CONFIG_NODE_CONDITION_MATCHER]
        );
    }
}